<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGeneralImageRequest extends FormRequest
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
            'banner'      => 'nullable|image',
            'logo_header' => 'nullable|image',
            'logo_footer' => 'nullable|image',
            'login'       => 'nullable|image',
            'register'    => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            "image"      => ':attribute phải là hình ảnh',
        ];
    }

    public function attributes()
    {
        return [
            'banner'      =>  "Banner" ,
            'logo_header' =>  "Logo header" ,
            'logo_footer' =>  "Logo footer" ,
            'login'       =>  "Ảnh login" ,
            'register'    =>  "Ảnh register" ,
        ];
    }
}
