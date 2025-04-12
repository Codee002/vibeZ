<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountRequest extends FormRequest
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
            "category_id" => ['required'],
            "des"         => ['required'],
            "percent"     => ['required', 'integer', "gt:0", "lt:100"],
            "start_at"    => ['required', 'date'],
            "end_at"      => ['required', 'date', 'after:start_at'],
        ];
    }

    public function messages()
    {
        return [
            "required"     => ':attribute không được rỗng',
            "date"         => ":attribute không hợp lệ",
            "integer"      => ":attribute không hợp lệ",
            "end_at.after" => "Ngày kết thúc phải lớn hơn ngày bắt đầu",
            "gt"           => ":attribute phải lớn hơn 0",
            "lt"           => ":attribute phải bé hơn 100",
        ];
    }

    public function attributes()
    {
        return [
            "category_id" => "Danh mục",
            "des"         => "Mô tả",
            "percent"     => "Trị giá",
            "start_at"    => "Ngày bắt đầu",
            "end_at"      => "Ngày kết thúc",
        ];
    }
}
