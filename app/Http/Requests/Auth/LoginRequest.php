<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'type' => ['required', 'string', 'in:admin,merchant,driver'],
        ];
    }

    public function authenticate(): void
    {
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'auth failed',
            ]);
        }

        // Additional Check: Ensure the user type matches the one they selected.
        if (Auth::user()->type->value !== $this->input('type')) {
            Auth::logout();

            throw ValidationException::withMessages([
                'type' => 'Your account type does not match the selected portal.',
            ]);
        }
    }
}
