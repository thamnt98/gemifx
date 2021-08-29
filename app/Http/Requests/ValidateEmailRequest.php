<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateEmailRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email phải đúng định dạng',
            'email.exists' => 'Email không phải là tài khoản đăng ký'
        ];
    }
}
