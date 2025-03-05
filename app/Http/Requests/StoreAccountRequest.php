<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => ['required', 'regex:/^[\p{L}\p{M}\s]+$/u'],
            'username' => ['required', 'regex:/^[a-zA-Z0-9]*$/', 'regex:/^[A-Za-z]{1,}/', 'min:4', 'max:32', 'unique:users'],
            'password' => ['required', 'min:8', 'max:20', 'confirmed'],
            'accept'   => ['required'],
            'captcha'   => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'required'           => ':attribute không được trống',
            'name.regex'         => 'Họ tên không hợp lệ',
            'username.regex'     => "Tên đăng nhập phải bắt đầu là chữ cái và không có ký tự đặc biệt",
            'username.min'       => 'Tên đăng nhập phải có độ dài từ 4 - 32 ký tự',
            'username.max'       => 'Tên đăng nhập phải có độ dài từ 4 - 32 ký tự',
            'username.unique'    => 'Tên đăng nhập đã tồn tại',
            'password.min'       => 'Mật khẩu phải có độ dài từ 8 - 20 ký tự',
            'password.max'       => 'Mật khẩu phải có độ dài từ 8 - 20 ký tự',
            'password.confirmed' => "Mật khẩu nhập lại không trùng khớp",
            'accept.required'    => 'Vui lòng đồng ý với điều khoản và chính sách bảo mật của chúng tôi',
        ];
    }

    public function attributes()
    {
        return [
            'name'                  => "Họ tên",
            'username'              => 'Tên đăng nhập',
            'password'              => 'Mật khẩu',
            'password_confirmation' => 'Mật khẩu',
            'captcha' => 'Mật khẩu',
        ];
    }
}
