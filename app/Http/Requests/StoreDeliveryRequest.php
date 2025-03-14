<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeliveryRequest extends FormRequest
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
            "address"  => ['required', 'regex:/^[\p{L}\p{M}\s\d\.\-\/\,]+$/u'],
            "phone" => ["required", "regex:/^(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b$/"],
        ];
    }

    public function messages()
    {
        return [
            "required" => ':attribute không được rỗng',
            "address.regex"    => "Địa chỉ không hợp lệ",
            "phone.regex"    => "Số điện thoại không hợp lệ",
            "name.regex"    => "Họ tên không hợp lệ",
        ];
    }

    public function attributes()
    {
        return [
            "name" => "Họ tên",
            "address"  => 'Địa chỉ',
            "phone" => "Số điện thoại",
        ];
    }
}
