<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Models\EmailOtp;
use App\Models\User;
use App\Notifications\Auth\PreRegistrationOtpNotification;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class AuthController extends Controller
{
    // === 1. LOGIN ===
    public function login(): View
    {
        return view('auth.login');
    }

    public function loginStore(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        return $this->redirectToDashboard();
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // === 2. PRE-REGISTRATION (EMAIL & OTP) ===
    public function requestEmail(): View
    {
        return view('auth.register-email');
    }

    public function sendOtp(SendOtpRequest $request): RedirectResponse
    {
        // Cooldown Check: Prevent resending an OTP if one was created less than 1 minute ago
        $recentOtp = EmailOtp::where('email', $request->email)->first();
        
        if ($recentOtp && Carbon::now()->diffInSeconds($recentOtp->created_at) < 60) {
            $secondsLeft = 60 - Carbon::now()->diffInSeconds($recentOtp->created_at);
            return back()->withErrors(['email' => "يرجى الانتظار لصالح الأمان لمدة {$secondsLeft} ثانية قبل إرسال كود جديد."]);
        }

        // Delete any old OTPs for this email to prevent spam/confusion
        EmailOtp::where('email', $request->email)->delete();

        // Generate 6-digit OTP
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store in DB
        EmailOtp::create([
            'email' => $request->email,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(15),
        ]);

        // Send Notification using anonymous mail route
        Notification::route('mail', $request->email)
                    ->notify(new PreRegistrationOtpNotification($code));

        // Save email in session to verify it in the next step
        session(['pending_register_email' => $request->email]);

        return redirect()->route('register.verify-otp')->with('status', 'otp-sent');
    }

    public function verifyOtpForm(): View|RedirectResponse
    {
        if (!session('pending_register_email')) {
            return redirect()->route('register.email');
        }

        return view('auth.register-verify-otp');
    }

    public function verifyOtp(VerifyOtpRequest $request): RedirectResponse
    {
        $email = $request->email;
        $otpRecord = EmailOtp::where('email', $email)
                             ->where('code', $request->code)
                             ->where('expires_at', '>', Carbon::now())
                             ->first();

        if (!$otpRecord) {
            return back()->withErrors(['code' => __('الرمز المدخل غير صحيح أو منتهي الصلاحية')]);
        }

        // OTP is correct! Clear it from DB.
        $otpRecord->delete();

        // Remove pending status, but mark as fully verified for registration phase
        session()->forget('pending_register_email');
        session(['verified_register_email' => $email]);

        return redirect()->route('register');
    }

    // === 3. REGISTRATION (FINAL STEP) ===
    public function register(): View|RedirectResponse
    {
        // User MUST have a verified email in session to access the registration form
        if (!session('verified_register_email')) {
            return redirect()->route('register.email');
        }

        return view('auth.register', [
            'email' => session('verified_register_email'),
        ]);
    }

    public function registerStore(RegisterRequest $request): RedirectResponse
    {
        // Security check to ensure they aren't submitting a different email
        if ($request->email !== session('verified_register_email')) {
            return back()->withErrors(['email' => 'البريد الإلكتروني لا يتطابق مع البريد الموثق.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'type' => $request->type,
            'password' => Hash::make($request->password),
            'email_verified_at' => Carbon::now(), // Mark as verified immediately
        ]);

        // Assign the appropriate Spatie Role to the new user based on their chosen type
        $user->assignRole($request->type);

        // Clear verification session
        session()->forget('verified_register_email');

        // Log the user in
        Auth::login($user);

        return $this->redirectToDashboard();
    }

    // === HELPERS ===
    private function redirectToDashboard(): RedirectResponse
    {
        $type = Auth::user()->type->value;
        return match ($type) {
            'admin' => redirect()->route('admin.dashboard'),
            'merchant' => redirect()->route('merchant.dashboard'),
            'driver' => redirect()->route('driver.dashboard'),
            default => redirect('/'),
        };
    }
}
