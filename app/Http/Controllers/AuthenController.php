<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginAccountRequest;
use App\Http\Requests\StoreAccountRequest;
use App\Models\User;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                return redirect()->route('admin.product');
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

        // Đăng nhập
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with([
            'success' => 'Đăng ký tài khoản thành công',]);
    }

    public function showFormForgot()
    {
        return view("auth.components.forgot");
    }

    public function showFormReset()
    {
        return view("auth.components.reset");
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
