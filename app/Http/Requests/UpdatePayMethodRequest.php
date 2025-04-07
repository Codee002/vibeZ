<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePayMethodRequest extends FormRequest
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
        $paymentId = $this->route('payment_method')->id;
        return [
            "name" => ['required', 'max:255', 'unique:payment_methods,name,'. $paymentId],
            "status" => 'required',
        ];
    }

    public function messages()
    {
        return [
            "required" => ':attribute không được rỗng',
            "unique"   => ':attribute đã tồn tại',
            "max"   => ':attribute không được lớn hơn 255 ký tự',
        ];
    }

    public function attributes()
    {
        return [
            "name" => 'Tên phương thức',
            "status" => 'Trạng thái',
        ];
    }
}
