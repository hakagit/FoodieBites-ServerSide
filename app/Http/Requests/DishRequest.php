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
            'price' => 'required|string',
            'category_id' => 'required|exists:categories,id', // Ensure the category exists
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The dish name is required.',
            'price.required' => 'The price is required.',
            'category_id.required' => 'The category ID is required.',
            'category_id.exists' => 'The selected category ID must exist in the categories table.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpg, jpeg, png.',
            'image.max' => 'The image may not be greater than 2MB.',
        ];
    }
}
