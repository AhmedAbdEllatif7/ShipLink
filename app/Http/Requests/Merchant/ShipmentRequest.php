<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ShipmentRequest extends FormRequest
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
        $rules = [
            'receiver_name' => ['required', 'string', 'max:255'],
            'receiver_phone' => ['required', 'string', 'max:20'],
            'receiver_address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:255'],
            'cod_amount' => ['required', 'numeric', 'min:0'],
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            foreach ($rules as $key => $rule) {
                array_unshift($rules[$key], 'sometimes');
            }
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'receiver_name' => 'اسم المستلم',
            'receiver_phone' => 'رقم هاتف المستلم',
            'receiver_address' => 'عنوان المستلم',
            'city' => 'المدينة',
            'cod_amount' => 'مبلغ التحصيل (COD)',
        ];
    }
}
