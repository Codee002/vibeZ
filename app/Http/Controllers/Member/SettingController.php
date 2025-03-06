<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEmailPhoneAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    // Thông tin cá nhân
    public function showUserInformation()
    {
        $user = Auth::user();
        return view('pages.components.setting_info', compact('user'));
    }

    public function updateEmailPhone(UpdateEmailPhoneAccount $request)
    {
        try {
            DB::transaction(function () use ($request) {
                /**
                 * @var User $user
                 */
                $user = Auth::user();

                $data = [
                    'email' => $request['email'],
                    'phone' => $request['phone'],
                ];
                if ($user['email'] != $request['email']) {
                    $data['email_active'] = '0';
                }
                // dd($data);
                $user->update($data);
            });
            return redirect()->route("setting.info")->with("success", "Cập nhật thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }

    public function updateName(Request $request)
    {
        $data = $request->validate([
            'name' => "required|regex:/^[\p{L}\p{M}\s]+$/u",
        ], [
            "name.required" => "Vui lòng nhập họ tên",
            "name.regex"    => "Họ tên không hợp lệ",
        ]);
        try {
            DB::transaction(function () use ($data) {
                /**
                 * @var User $user
                 */
                $user = Auth::user();
                $user->update($data);
            });
            return redirect()->route("setting.info")->with("success", "Cập nhật thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }

    public function updateBirthday(Request $request)
    {
        $data = $request->validate([
            'birthday' => 'required|date|before:' . Carbon::now()->toDateString(),
        ], [
            "birthday.required" => "Vui lòng nhập ngày sinh",
            "birthday.date"     => "Ngày sinh không hợp lệ",
            "birthday.before"   => "Ngày sinh phải nhỏ hơn ngày hiện tại",
        ]);
        try {
            DB::transaction(function () use ($data) {
                /**
                 * @var User $user
                 */
                $user = Auth::user();
                $user->update($data);
            });
            return redirect()->route("setting.info")->with("success", "Cập nhật thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }

    public function updateGender(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                /**
                 * @var User $user
                 */
                $user = Auth::user();
                $user->update($request->all());
            });
            return redirect()->route("setting.info")->with("success", "Cập nhật thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }

    // Bảo mật
    public function showSecurity()
    {
        $user = Auth::user();
        return view('pages.components.setting_security', compact('user'));
    }

    public function changePassword(Request $request)
    {
        // dd($request);
        $data = $request->validate([
            'oldpass'               => 'required',
            'password'              => 'required|min:8|max:20|confirmed',
            'password_confirmation' => 'required',
        ], [
            'oldpass.required'               => 'Mật khẩu cũ không được để trống',
            'password.required'              => 'Mật khẩu mới không được để trống',
            'password.min'                   => 'Mật khẩu mới phải từ 8 - 20 ký tự',
            'password.confirmed'             => 'Mật khẩu xác nhận không khớp',
            'password_confirmation.required' => 'Mật khẩu xác nhận không được để trống',
        ]);

        $user = Auth::user();
        if (! Hash::check($data['oldpass'], $user->password)) {
            return back()->withErrors(['oldpass' => 'Mật khẩu không đúng']);
        }

        $newPass = Hash::make($data['password']);

        try {
            DB::transaction(function () use ($user, $newPass) {
                /**
                 * @var User $user
                 */
                $user->update([
                    'password' => $newPass,
                ]);
            });
            return redirect()->route("setting.security")->with("success", "Đổi mật khẩu thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }

    }

}
