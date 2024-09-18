<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change if you need authorization logic
    }


    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'expiry' => 'required|date',
            'user_id' => 'required|exists:users,id', // Ensure the user exists
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The inventory name is required.',
            'quantity.required' => 'The quantity is required.',
            'expiry.required' => 'The expiry date is required.',
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user ID must exist in the admins table.',
        ];
    }
}
