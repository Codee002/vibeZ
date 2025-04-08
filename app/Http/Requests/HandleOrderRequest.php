<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HandleOrderRequest extends FormRequest
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
        $rules = [];
        foreach (request()->get('quantity', []) as $productId => $sizes) {
            foreach ($sizes as $size => $warehouses) {
                foreach ($warehouses as $warehouseId => $quantity) {
                    $rules["quantity.$productId.$size.$warehouseId"] = 'integer|min:1';
                }
            }
        }
        return $rules;
    }

    public function messages(): array
    {
        $messages = [];

        foreach (request()->get('quantity', []) as $productId => $sizes) {
            foreach ($sizes as $size => $warehouses) {
                foreach ($warehouses as $warehouseId => $quantity) {
                    $key                       = "quantity.$productId.$size.$warehouseId";
                    $messages["$key.integer"]  = "Số lượng phải là một số nguyên.";
                    $messages["$key.min"]      = "Số lượng phải lớn hơn hoặc bằng 1.";
                }
            }
        }

        return $messages;
    }
}
