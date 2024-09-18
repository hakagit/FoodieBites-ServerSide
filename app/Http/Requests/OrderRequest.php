<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization logic
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'driver_id' => 'nullable|exists:drivers,id', // Optional driver ID
            'dishIds' => 'required|array', // Ensure dishIds is an array
            'dishIds.*' => 'integer|exists:dishes,id', // Each ID must be an integer and exist in the dishes table
        ];
    }

    public function messages()
    {
        return [];
    }
}
