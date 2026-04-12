<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user'); // parameter name in route

        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'type' => 'required|string|in:admin,merchant,driver',
            'roles' => 'array',
            
            // Merchant fields
            'company_name' => 'required_if:type,merchant|nullable|string|max:255',
            
            // Driver fields
            'vehicle_type' => 'required_if:type,driver|nullable|string|in:motorcycle,car,van,truck',
        ];

        // Conditional password validation
        if ($this->isMethod('POST')) {
            $rules['password'] = 'required|min:8|confirmed';
        } else {
            $rules['password'] = 'nullable|min:8|confirmed';
        }

        return $rules;
    }
}
