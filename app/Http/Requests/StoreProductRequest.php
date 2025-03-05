<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            "name"     => ['required', 'regex:/^[\p{L}\p{M}\s]+$/u'],
            "category" => 'required',
            "sizes"    => 'required|array',
            "sizes.*"  => 'required|integer',
            'des'      => 'required',
            'images'   => 'required|array',
            'images.*' => 'required|image',
        ];
    }

    public function messages()
    {
        return [
            "regex"    => ':attribute không chứa ký tự đặc biệt',
            "required" => ':attribute không được rỗng',
            "images.*" => ":attribute phải là hình ảnh",
        ];
    }

    public function attributes()
    {
        return [
            "name"     => 'Tên sản phẩm',
            'images.*' => "File được chọn",
            "sizes"    => "Kích thước",
            "category" => 'Danh mục',
            "des"      => 'Mô tả',
            'images'   => "Ảnh",
        ];
    }
}
