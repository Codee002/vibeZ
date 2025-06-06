<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDistributorRequest extends FormRequest
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
        $distributorId = $this->route('distributor')->id;
        return [
            "name"    => ['required', 'regex:/^[\p{L}\p{M}\s\d\.\-]+$/u', 'unique:distributors,name,' . $distributorId],
            "address" => ['required', 'regex:/^[\p{L}\p{M}\s]+$/u'],
            "email"   => "required|email|unique:distributors,email," . $distributorId,
        ];
    }

    public function messages()
    {
        return [
            "name.unique"    => 'Tên nhà cung cấp đã tồn tại',
            "name.regex"    => 'Tên không chứa ký tự đặc biệt',
            "address.regex" => 'Địa chỉ không chứa ký tự đặc biệt',
            "required"      => ':attribute không được rỗng',
            "email"         => ':attribute không đúng định dạng',
            "email.unique"  => 'Email đã tồn tại',
        ];
    }

    public function attributes()
    {
        return [
            "name"    => 'Tên',
            "email"   => 'Email',
            "address" => 'Địa chỉ',
        ];
    }
}
