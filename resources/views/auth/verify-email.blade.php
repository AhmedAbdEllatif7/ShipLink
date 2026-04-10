<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4 dark:bg-blue-900">
            <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04a11.357 11.357 0 00-1.573 7.811c.19 2.054.735 4.07 1.573 5.91a11.952 11.952 0 008.618 7.333a11.952 11.952 0 008.618-7.333c.838-1.84 1.383-3.856 1.573-5.91a11.357 11.357 0 00-1.573-7.811z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
            {{ __('Confirm Verification Code') }}
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Please enter the 6-digit code we sent to your email address.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 text-sm font-medium rounded">
            {{ __('A new verification code has been sent to your email.') }}
        </div>
    @endif

    <div class="space-y-6">
        <form method="POST" action="{{ route('verification.verify_code') }}">
            @csrf
            
            <div>
                <x-input-label for="code" :value="__('Verification Code')" class="sr-only" />
                <x-text-input id="code" class="block mt-1 w-full text-center text-2xl tracking-widest font-bold" type="text" name="code" :value="old('code')" required autofocus placeholder="000000" maxlength="6" />
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-primary-button class="w-full justify-center py-3 bg-blue-600 hover:bg-blue-700">
                    {{ __('Verify Code') }}
                </x-primary-button>
            </div>
        </form>

        <div class="flex flex-col items-center space-y-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">
                    {{ __('Resend Verification Code') }}
                </button>
            </form>


        </div>
    </div>
</x-guest-layout>
