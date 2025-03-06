<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginAccountRequest;
use App\Http\Requests\StoreAccountRequest;
use App\Models\User;
use Carbon\Carbon;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthenController extends Controller
{
    private $captcha;
    public function __construct()
    {
        // Tạo capcha
        $phraseBuilder = new PhraseBuilder(5, '0123456789');
        $this->captcha = new CaptchaBuilder(null, $phraseBuilder);
        $this->captcha->build();
    }

    // Đăng nhập
    public function showFormLogin()
    {
        // Lưu captcha
        session(['captcha' => $this->captcha->getPhrase()]);
        return view("auth.components.login", [
            'captcha' => $this->captcha,
        ]);
    }

    public function handleLogin(LoginAccountRequest $request)
    {
        // Kiểm tra Capcha
        if ($request['captcha'] != session('captcha')) {
            return redirect()->back()->withErrors([
                'captcha' => 'Capcha không chính xác',
            ])->withInput();
        }

        if (Auth::attempt([
            'username' => $request['username'],
            'password' => $request['password'],
        ])) {
            $request->session()->regenerate();

            /**
             * @var User $user
             */
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.product.index');
            }

            return redirect()->route('home');
        }

        return back()->with([
            'danger' => 'Tài khoản hoặc mật khẩu không đúng',
        ])->onlyInput('username');
    }

    // Đăng ký
    public function showFormRegister()
    {
        // Lưu captcha
        session(['captcha' => $this->captcha->getPhrase()]);
        return view("auth.components.register", [
            'captcha' => $this->captcha,
        ]);
    }

    public function handleRegister(StoreAccountRequest $request)
    {
        // Kiểm tra Capcha
        if ($request['captcha'] != session('captcha')) {
            return redirect()->back()->withErrors([
                'captcha' => 'Capcha không chính xác',
            ])->withInput();
        }

        $user = User::query()->create($request->all());

        return redirect()->route('/register')->with([
            'success' => 'Đăng ký tài khoản thành công']);
    }

    public function showFormForgot()
    {
        // Lưu captcha
        session(['captcha' => $this->captcha->getPhrase()]);
        return view("auth.components.forgot", [
            'captcha' => $this->captcha,
        ]);
    }

    public function handleForgot(Request $request)
    {
        $data = $request->validate(
            [
                'username' => ['required'],
                'captcha'  => ['required'],
            ],
            [
                'required' => ':attribute không được trống',
            ],
            [
                'username' => 'Tên đăng nhập',
                'captcha'  => 'Captcha',
            ],
        );
        // Kiểm tra Capcha
        if ($request['captcha'] != session('captcha')) {
            return redirect()->back()->withErrors([
                'captcha' => 'Capcha không chính xác',
            ])->withInput();
        }
        $user = User::query()->where("username", $request['username'])
            ->first();

        if (! $user) {
            return redirect()->back()->with([
                'danger' => 'Không tìm thấy tên đăng nhập',
            ])->withInput();
        }

        return view("auth.components.sendBy", [
            "user" => $user,
        ]);

    }

    public function showFormReset()
    {
        // Lưu captcha
        session(['captcha' => $this->captcha->getPhrase()]);
        return view("auth.components.reset", [
            'captcha' => $this->captcha,
        ]);
    }

    public function handleReset()
    {
        dd("Reset");
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    // Kích hoạt Email
    public function sendEmail(Request $request)
    {

        if ($request->isMethod("POST")) {
            // dd($request);
            // Kiểm tra Capcha
            if ($request['captcha'] != session('captcha')) {
                return redirect()->back()->withErrors([
                    'captcha' => 'Capcha không chính xác',
                ])->withInput();
            }

            // Tạo token ngẫu nhiên
            $token = Str::random(60);
            $link  = $request->schemeAndHttpHost() . "/activeEmail/" . $token;
            $name  = "Kích hoạt gmail";

            // Gửi gmail
            $user = Auth::user();
            $data = [
                'content' => 'Để kích hoạt gmail, vui lòng vào link dưới đây:',
                'token'   => $link,
                'user'    => $user,
                'name'    => $name,
            ];
            try {
                Mail::send('auth.components.emailView', $data, function ($message) use ($user) {
                    $message->from(env("MAIL_FROM_ADDRESS"), 'vibeZ');
                    $message->to($user['email']);
                    $message->subject('Kích hoạt gmail');
                });
                DB::transaction(function () use ($user, $token) {
                    /**
                     * @var User $user
                     */
                    $user = Auth::user();
                    $user->update([
                        'email_token' => $token,
                    ]);
                });
            } catch (\Throwable $th) {
                return redirect()->back()->with("danger", $th->getMessage())->withInput();
            }
            session()->flash("success", "Gửi mail thành công, hãy kiểm tra gmail của bạn");
        }
        // Lưu captcha
        session(['captcha' => $this->captcha->getPhrase()]);
        $user = Auth::user();
        return view("auth.components.activeEmail", [
            "user"    => $user,
            'captcha' => $this->captcha,
        ]);
    }

    public function activeEmail($token)
    {
        if (! Auth::check()) {
            abort(403);
        }

        $user = Auth::user();
        if ($user['email_token'] == $token) {
            try {
                DB::transaction(function () use ($user) {
                    /**
                     * @var User $user
                     */
                    $user->update([
                        'email_token'       => null,
                        'email_active'      => 1,
                        'email_verified_at' => Carbon::now()->toDateString(),
                    ]);
                });
                return redirect()->route("setting.info")->with("success", "Kích hoạt mail thành công");
            } catch (\Throwable $th) {
                return redirect()->back()->with("danger", $th->getMessage())->withInput();
            }
        } else {
            return view('auth.components.tokenError');
        }

    }
}
