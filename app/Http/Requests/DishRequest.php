<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DishRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization logic
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|string', // You may want to validate this as a decimal or float
            'category_id' => 'required|exists:categories,id', // Ensure the category exists
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The dish name is required.',
            'price.required' => 'The price is required.',
            'category_id.required' => 'The category ID is required.',
            'category_id.exists' => 'The selected category ID must exist in the categories table.',
        ];
    }
}
