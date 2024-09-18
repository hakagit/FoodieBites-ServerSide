<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization logic
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255', // Validate the name field
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The supplier name is required.',
        ];
    }
}
