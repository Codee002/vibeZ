<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluateRequest extends FormRequest
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
            'ratings.*' => 'required|integer|min:1',
            'images.*'  => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            "required" => ':attribute không được trống !',
            "ratings.*.min" => 'Số sao không được trống !',
            "image"    => ':attribute phải là hình ảnh',
        ];
    }

    public function attributes()
    {
        return [
            "ratings"  => "Số sao",
            'images.*' => "File được chọn",
        ];
    }
}
