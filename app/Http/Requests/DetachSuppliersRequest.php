<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetachSuppliersRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change if you need authorization logic
    }

    public function rules()
    {
        return [
            'supplier_ids' => 'required|array',
            'supplier_ids.*' => 'exists:suppliers,id', // Validate that each supplier ID exists
        ];
    }

    public function messages()
    {
        return [
            'supplier_ids.required' => 'Supplier IDs are required.',
            'supplier_ids.array' => 'Supplier IDs must be an array.',
            'supplier_ids.*.exists' => 'One or more selected supplier IDs do not exist.',
        ];
    }
}
