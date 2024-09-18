<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization logic
    }

    public function rules()
    {
        $categoryId = $this->route('category'); // Get the category ID from the route if updating

        return [
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'user_id' => 'required|exists:users,id', // Ensure the admin exists
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The category name is required.',
            'quantity.required' => 'The quantity is required.',
            'user_id.required' => 'The admin ID is required.',
            'user_id.exists' => 'The selected admin ID must exist in the admins table.',
        ];
    }
}
