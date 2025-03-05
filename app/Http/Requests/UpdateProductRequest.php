<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            "name"          => ['required', 'regex:/^[\p{L}\p{M}\s]+$/u'],
            "category"      => 'required',
            "sizes"         => 'required|array',
            "sizes.*"       => 'required|integer',
            'des'           => 'required',
            'images'        => 'nullable|array',
            'images.*'      => 'nullable|image',
            'addImages'     => 'nullable|array',
            'addImages.*'   => 'nullable|image',
            'deleteTmages'  => 'nullable',
            "buying_price"  => "required|numeric|min:1",
            "selling_price" => "required|numeric|min:1",
        ];

    }

    public function messages()
    {
        return [
            "regex"      => ':attribute không chứa ký tự đặc biệt',
            "required"   => ':attribute không được rỗng',
            "images.*"   => ":attribute phải là hình ảnh",
            "addmages.*" => ":attribute phải là hình ảnh",
            "numeric"    => ":attribute phải là số",
            "min"        => ":attribute phải lớn hơn 0",
        ];
    }

    public function attributes()
    {
        return [
            "name"          => 'Tên sản phẩm',
            'images.*'      => "File được chọn",
            'addImages.*'   => "File được chọn",
            "sizes"         => "Kích thước",
            "category"      => 'Danh mục',
            "des"           => 'Mô tả',
            'images'        => "Ảnh",
            'buying_price'  => 'Giá mua',
            'selling_price' => 'Giá bán',
        ];
    }
}
