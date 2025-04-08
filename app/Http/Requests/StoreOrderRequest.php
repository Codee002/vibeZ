<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            "payMethod" => "required",
            "delivery"  => "required",
        ];
    }

    public function messages()
    {
        return [
            "required" => 'Vui lòng chọn :attribute',
        ];
    }

    public function attributes()
    {
        return [
            "payMethod" => "phương thức thanh toán",
            "delivery"  => "thông tin nhận hàng",
        ];
    }
}
