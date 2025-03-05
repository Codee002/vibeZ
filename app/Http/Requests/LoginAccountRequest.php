<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginAccountRequest extends FormRequest
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
            'username' => ['required'],
            'password' => ['required'],
            'captcha' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'required'           => ':attribute không được trống',
        ];
    }

    public function attributes()
    {
        return [
            'username'              => 'Tên đăng nhập',
            'password'              => 'Mật khẩu',
            'captcha'              => 'Captcha',
        ];
    }
}
