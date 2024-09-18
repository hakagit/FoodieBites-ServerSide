<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you need authorization logic
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'driver_license' => 'required|string|max:255',
            'order_id' => 'required|exists:orders,id', // Ensure the order exists
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The driver name is required.',
            'driver_license.required' => 'The driver license is required.',
            'order_id.required' => 'The order ID is required.',
            'order_id.exists' => 'The selected order ID must exist in the orders table.',
        ];
    }
}
