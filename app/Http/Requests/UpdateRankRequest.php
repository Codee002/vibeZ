<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRankRequest extends FormRequest
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
        $rankId = $this->route('rank')->id;
        return [
            "type"     => ['required', 'regex:/^[\p{L}\p{M}\s]+$/u', 'unique:ranks,type,' . $rankId],
            "point"    => ['required', 'numeric', "gt:0", 'unique:ranks,point,' . $rankId],
            "discount" => ['required', 'integer', "gt:0", "lt:100"],
        ];
    }

    public function messages()
    {
        return [
            "type.regex" => 'Cấp không hợp lệ',
            "unique"     => ':attribute đã tồn tại',
            "required"   => ':attribute không được rỗng',
            "integer"    => ":attribute không hợp lệ",
            "gt"         => ":attribute phải lớn hơn 0",
            "lt"         => ":attribute phải bé hơn 100",
            "numeric"    => ":attribute phải là số",
        ];
    }

    public function attributes()
    {
        return [
            "type"     => "Cấp",
            "point"    => 'Số điểm',
            "discount" => 'Phần trăm khuyến mãi',
        ];
    }
}
