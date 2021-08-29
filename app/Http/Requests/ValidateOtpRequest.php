<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateOtpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'otp' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'otp.required' => 'Otp không được để trống',
            'otp.numeric' => 'Otp phai la so'
        ];
    }
}
