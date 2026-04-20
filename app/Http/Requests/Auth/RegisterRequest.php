<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', Rule::in(['merchant', 'driver'])],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'الاسم مطلوب.',
            'name.string'       => 'يجب أن يكون الاسم نصاً.',
            'name.max'          => 'الاسم يجب ألا يتجاوز 255 حرفاً.',
            'email.required'    => 'البريد الإلكتروني مطلوب.',
            'email.email'       => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.unique'      => 'هذا البريد الإلكتروني مسجل مسبقاً.',
            'phone.required'    => 'رقم الهاتف مطلوب.',
            'address.required'  => 'العنوان مطلوب.',
            'type.required'     => 'يجب اختيار نوع الحساب.',
            'type.in'           => 'نوع الحساب غير صحيح.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.confirmed'=> 'تأكيد كلمة المرور غير متطابق.',
        ];
    }
}
