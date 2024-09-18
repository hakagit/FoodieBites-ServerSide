<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to make this request
    }

    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'email.required' => 'The email field is required.',
    //         'password.required' => 'The password field is required.',
    //     ];
    // }
}
