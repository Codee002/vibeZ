<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceiptRequest extends FormRequest
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
        // dd(request()->product[10][40]['sale_price']);
        // dd(request(), request()->product[10][40]['sale_price']);
        return [
            "warehouse" => 'required',
            "product.*.*.purchase_price" => "required|numeric|min:1",
            "product.*.*.sale_price" => "required|numeric|min:1",
            "product.*.*.quantity" => "required|integer|min:1",
        ];
    }

    public function messages()
    {
        return [
            "required" => ':attribute không được rỗng',
            "numeric" => ":attribute phải là số",
            "min" => ":attribute phải lớn hơn 0",
            "integer" => ":attribute phải là số nguyên",
        ];
    }

    public function attributes()
    {
        return [
            "warehouse" => "Kho",
            "product.*.*.purchase_price" => 'Giá nhập',
            "product.*.*.sale_price" => 'Giá bán',
            "product.*.*.quantity" => 'Số lượng',
        ];
    }

}
