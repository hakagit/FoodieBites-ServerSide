<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization logic
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|string|max:255', // Consider changing to a numeric type if needed
            'order_id' => 'required|exists:orders,id', // Ensure the order exists
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The item name is required.',
            'quantity.required' => 'The quantity is required.',
            'price.required' => 'The price is required.',
            'order_id.required' => 'The order ID is required.',
            'order_id.exists' => 'The selected order ID must exist in the orders table.',
        ];
    }
}
