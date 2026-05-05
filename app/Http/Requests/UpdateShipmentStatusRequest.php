<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateShipmentStatusRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => [
                'required',
                new \Illuminate\Validation\Rules\Enum(\App\Enums\ShipmentStatus::class),
            ],
            'notes' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'status' => 'حالة الشحنة',
            'notes' => 'ملاحظات التحديث',
        ];
    }
}
