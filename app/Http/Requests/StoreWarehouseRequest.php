<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseRequest extends FormRequest
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
            "address"  => ['required', 'regex:/^[\p{L}\p{M}\s]+$/u', 'unique:warehouses'],
            "capacity" => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            "required" => ':attribute không được rỗng',
            "unique"   => ':attribute đã tồn tại',
            "integer"  => ':attribute phải là số nguyên',
            "min"      => ":attribute phải lớn hơn 0",
            "regex"    => ":attribute là chữ cái không chứa ký tự đặc biệt",
        ];
    }

    public function attributes()
    {
        return [
            "address"  => 'Địa chỉ',
            "capacity" => "Dung tích kho",
        ];
    }
}
