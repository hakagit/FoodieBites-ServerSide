<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization logic
    }

    public function rules()
    {
        return [
            'street' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id', // Ensure the customer exists
        ];
    }

    public function messages()
    {
        return [
            'street.required' => 'The street address is required.',
            'customer_id.required' => 'The customer ID is required.',
            'customer_id.exists' => 'The selected customer ID must exist in the customers table.',
        ];
    }
}
