<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEmailPhoneAccount extends FormRequest
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
        $user = Auth::user();
        return [
            "email" => "required|email|unique:users,email," . $user['id'],
            "phone" => ['required', "regex:/^(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b$/", "unique:users,phone," . $user['id']],
        ];
    }

    public function messages()
    {
        return [
            "required"     => ':attribute không được rỗng',
            "email"        => ':attribute không đúng định dạng',
            "email.unique" => 'Email đã tồn tại',
            "phone.unique" => 'Số điện thoại đã tồn tại',
            "regex"        => ":attribute không đúng định dạng",
        ];
    }

    public function attributes()
    {
        return [
            "email" => "Email",
            "phone" => "Số điện thoại",
        ];
    }
}
