<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvaluateRequest extends FormRequest
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
            'rating' => 'required|integer|min:1',
            'image'  => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            "required" => ':attribute không được trống !',
            "rating.min" => 'Số sao không được trống !',
            "image"    => ':attribute phải là hình ảnh',
        ];
    }

    public function attributes()
    {
        return [
            "rating"  => "Số sao",
            'image' => "File được chọn",
        ];
    }
}
