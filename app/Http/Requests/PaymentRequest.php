<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization logic
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'card_number' => 'required|string', // Consider adding more validation for card number
            'order_id' => 'required|exists:orders,id', // Ensure the order exists
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The payment name is required.',
            'card_number.required' => 'The card number is required.',
            'order_id.required' => 'The order ID is required.',
            'order_id.exists' => 'The selected order ID must exist in the orders table.',
        ];
    }
}
