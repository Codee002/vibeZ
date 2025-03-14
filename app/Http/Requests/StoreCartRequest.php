<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
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
        // dd(request());
        return [
            "quantity" => "required|integer|min:1"
        ];
    }

    public function messages()
    {
        return [
            "quantity.required" => "Số lượng không được trống",
            "quantity.integer" => "Số lượng phải là số nguyên",
            "quantity.min" => "Số lượng phải lớn hơn 0",
        ];
    }
}
