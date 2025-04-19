<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginAccountRequest;
use App\Http\Requests\StoreAccountRequest;
use App\Models\Cart;
use App\Models\User;
use Carbon\Carbon;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        // Xóa session Forgot User
        session()->forget("userForgot");
        session()->forget("userChangePassword");

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
            /**
             * @var User $user
             */
            $user = Auth::user();

            if ($user['two_step_auth'] == 0) {
                $request->session()->regenerate();
                if ($user->isAdmin()) {
                    return redirect()->route('admin.product.index');
                }
                return redirect()->route('home');
            } else {
                Auth::logout();
                // Tạo token ngẫu nhiên
                $token = Str::random(60);
                $link  = $request->schemeAndHttpHost() . "/checkLoginToken/" . $user['id'] . '/' . $token;
                $name  = "Xác thực 2 bước";

                // Gửi gmail
                $data = [
                    'content' => 'Có phải bạn đang đăng nhập? <br>Để đăng nhập hãy xác thực bằng link dưới đây:',
                    'token'   => $link,
                    'user'    => $user,
                    'name'    => $name,
                ];
                try {
                    Mail::send('auth.components.emailView', $data, function ($message) use ($user) {
                        $message->from(env("MAIL_FROM_ADDRESS"), 'vibeZ');
                        $message->to($user['email']);
                        $message->subject('Xác thực 2 bước');
                    });
                    DB::transaction(function () use ($user, $token) {
                        /**
                         * @var User $user
                         */
                        $user->update([
                            'login_token' => $token,
                        ]);
                    });
                } catch (\Throwable $th) {
                    return redirect()->back()->with("danger", $th->getMessage())->withInput();
                }
                return redirect()->back()->with(
                    ['success' => "Hãy kiểm tra gmail để hoàn thành xác thực 2 bước"],
                );
            }
        }
        return back()->with([
            'danger' => 'Tài khoản hoặc mật khẩu không đúng',
        ])->onlyInput('username');
    }

    // Xác thực 2 bước
    public function checkLoginToken($userId, $token)
    {
        $user = User::query()->find($userId);
        if ($user['login_token'] == $token) {
            try {
                DB::transaction(function () use ($user) {
                    /**
                     * @var User $user
                     */
                    $user->update([
                        'login_token' => null,
                    ]);
                });
                Auth::login($user);
                request()->session()->regenerate();
                return redirect()->route("home");
            } catch (\Throwable $th) {
                return redirect()->back()->with("danger", $th->getMessage())->withInput();
            }
        } else {
            return view('auth.components.tokenError');
        }
    }

    // Đăng ký
    public function showFormRegister()
    {
        // Xóa session Forgot User
        session()->forget("userForgot");
        session()->forget("userChangePassword");

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

        // Tạo giỏ hàng
        $cart = Cart::query()->create([
            "user_id" => $user['id'],
        ]);

        return redirect()->route('register')->with([
            'success' => 'Đăng ký tài khoản thành công']);
    }

    // Quên mật khẩu
    public function showFormForgot()
    {
        // Xóa session Forgot User
        session()->forget("userForgot");
        session()->forget("userChangePassword");

        // Lưu captcha
        session(['captcha' => $this->captcha->getPhrase()]);
        return view("auth.components.forgot", [
            'captcha' => $this->captcha,
        ]);
    }

    // Tìm tài khoản quên mật khẩu
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

        session(["userForgot" => $user['id']]);
        return redirect()->route("sendBy");
    }

    // View phương thức gửi token
    public function sendBy()
    {
        if (! session("userForgot")) {
            return abort(403);
        }

        $user = User::query()->find(session("userForgot"));
        return view("auth.components.sendBy", [
            'user' => $user,
        ]);
    }

    // Chọn phương thức gửi forgotToken
    public function getTokenForgot(Request $request, User $user)
    {
        if (! $user['email']) {
            return redirect()->back()->with([
                'danger' => 'Tài khoản chưa cập nhật email',
            ]);
        }
        if ($user['email_active'] == 0) {
            return redirect()->back()->with([
                'danger' => 'Email chưa kích hoạt',
            ]);
        }

        // Tạo token ngẫu nhiên
        $token = Str::random(60);
        $link  = $request->schemeAndHttpHost() . "/checkForgotToken/" . $user['id'] . '/' . $token;
        $name  = "Lấy lại mật khẩu";

        // Gửi gmail
        $data = [
            'content' => 'Để lấy lại mật khẩu, vui lòng vào link dưới đây:',
            'token'   => $link,
            'user'    => $user,
            'name'    => $name,
        ];
        try {
            Mail::send('auth.components.emailView', $data, function ($message) use ($user) {
                $message->from(env("MAIL_FROM_ADDRESS"), 'vibeZ');
                $message->to($user['email']);
                $message->subject('Lấy lại mật khẩu');
            });
            DB::transaction(function () use ($user, $token) {
                /**
                 * @var User $user
                 */
                $user->update([
                    'email_token' => $token,
                ]);
            });
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }

        return redirect()->back()->with(
            ['success' => "Gửi mail thành công, hãy kiểm tra gmail"],
        );
    }

    // Kiểm tra token forgot
    public function checkForgotToken($userId, $token)
    {
        $user = User::query()->find($userId);
        if ($user['email_token'] == $token) {
            try {
                DB::transaction(function () use ($user) {
                    /**
                     * @var User $user
                     */
                    $user->update([
                        'email_token' => null,
                    ]);
                });

                session(["userChangePassword" => $userId]);
                return redirect()->route("reset")->with("success", "Kiểm tra thành công, vui lòng nhập mật khẩu mới");
            } catch (\Throwable $th) {
                return redirect()->back()->with("danger", $th->getMessage())->withInput();
            }
        } else {
            return view('auth.components.tokenError');
        }
    }

    // View Reset
    public function showFormReset(Request $request)
    {
        $user = User::query()->find(session("userChangePassword"));
        if (! $user) {
            abort(403);
        }

        return view("auth.components.reset", [
            'user' => $user,
        ]);
    }

    // Đặt lại mật khẩu
    public function handleReset(Request $request, User $user)
    {
        $data = $request->validate([
            'password'              => ['required', 'min:8', 'max:20', 'confirmed'],
            'password_confirmation' => ['required'],
        ], [
            'password.required'              => 'Mật khẩu không được trống',
            'password_confirmation.required' => 'Mật khẩu nhập lại không được trống',
            'password.min'                   => 'Mật khẩu phải có độ dài từ 8 - 20 ký tự',
            'password.max'                   => 'Mật khẩu phải có độ dài từ 8 - 20 ký tự',
            'password.confirmed'             => "Mật khẩu nhập lại không trùng khớp",
        ]);

        // Tắt xác thực 2 bước
        $password = Hash::make($data['password']);
        $user->update([
            'password'      => $password,
            'two_step_auth' => "0", // Tắt xác thực 2 bước
        ]);

        return redirect()->route('login')->with([
            'success' => 'Đổi mật khẩu thành công']);
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Kích hoạt Email
    public function sendEmail(Request $request)
    {

        if ($request->isMethod("POST")) {
            // Kiểm tra Capcha
            if ($request['captcha'] != session('captcha')) {
                return redirect()->back()->withErrors([
                    'captcha' => 'Capcha không chính xác',
                ])->withInput();
            }

            $user = Auth::user();
            if ($user['email_active'] == 1) {
                return redirect()->back()->with([
                    'danger' => 'Email đã được kích hoạt!',
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

    // Kiểm tra token active Email
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
