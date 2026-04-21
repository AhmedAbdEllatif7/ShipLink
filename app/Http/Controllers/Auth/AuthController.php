<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Enums\UserType;
use App\Events\Auth\OtpRequested;
use App\Models\EmailOtp;
use App\Models\User;
use App\Models\Merchant;
use App\Models\Driver;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthController extends Controller
{
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

    // === PRE-REGISTRATION (EMAIL & OTP) ===
    public function requestEmail(): View
    {
        return view('auth.register-email');
    }



    

    // ================================== Start Send OTP =====================================
    public function sendOtp(SendOtpRequest $request): RedirectResponse
    {
        // Cooldown Check: Prevent resending an OTP if one was created less than 1 minute ago
        if ($response = $this->hasActiveOtp($request->email)) {
            return $response;
        }
        
        $code = $this->createOtp($request->email);

        event(new OtpRequested($request->email, $code));

        // Save email in session to verify it in the next step
        session(['pending_register_email' => $request->email]);

        return redirect()->route('register.verify-otp')->with('status', 'otp-sent');
    }

    private function hasActiveOtp(string $email)
    {
        $recentOtp = EmailOtp::where('email', $email)->first();
        
        if ($recentOtp && Carbon::now()->diffInSeconds($recentOtp->created_at) < 60) {
            $secondsLeft = ceil(60 - Carbon::now()->diffInSeconds($recentOtp->created_at));
            return back()->withErrors(['email' => "يرجى الانتظار لصالح الأمان لمدة {$secondsLeft} ثانية قبل إرسال كود جديد."]);
        }
    }

    private function createOtp(string $email): string
    {
        EmailOtp::where('email', $email)->delete();

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        EmailOtp::create([
            'email'      => $email,
            'code'       => $code,
            'expires_at' => Carbon::now()->addMinutes(15),
        ]);

        return $code;
    }

    // ================================== End Send OTP =====================================






    public function verifyOtpForm(): View|RedirectResponse
    {
        if (!session('pending_register_email')) {
            return redirect()->route('register.email');
        }

        return view('auth.register-verify-otp');
    }

    

    public function verifyOtp(VerifyOtpRequest $request): RedirectResponse
    {
        $otpRecord = $this->findValidOtp($request->email, $request->code);

        if (!$otpRecord) {
            return back()->withErrors(['code' => 'الرمز المدخل غير صحيح أو منتهي الصلاحية']);
        }

        // OTP is correct! Clear it from DB.
        $otpRecord->delete();

        session()->forget('pending_register_email');
        session(['verified_register_email' => $request->email]);

        return redirect()->route('register');
    }


    private function findValidOtp(string $email, string $code)
    {
        return EmailOtp::where('email', $email)
                    ->where('code', $code)
                    ->where('expires_at', '>', Carbon::now())
                    ->first();
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
        if ($response = $this->validateVerifiedEmail($request->email)) {
            return $response;
        }

        try {
            return $this->registerUser($request);
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'حدث خطأ أثناء إنشاء الحساب، يرجى المحاولة مرة أخرى.']);
        }
    }

    private function registerUser(RegisterRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'type' => $request->type,
                'password' => Hash::make($request->password),
                'email_verified_at' => Carbon::now(),
            ]);

            $user->assignRole($request->type);
            $this->createProfile($user, $request);

            session()->forget('verified_register_email');

            Auth::login($user);

            return $this->redirectToDashboard();
        });
    }


    private function createProfile(User $user, RegisterRequest $request): void
    {
        if ($user->type === UserType::MERCHANT) {
            Merchant::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
            ]);
        } elseif ($user->type === UserType::DRIVER) {
            Driver::create([
                'user_id' => $user->id,
                'vehicle_type' => $request->vehicle_type,
            ]);
        }
    }


    private function validateVerifiedEmail(string $email)
    {
        if ($email !== session('verified_register_email')) {
            return back()->withErrors(['email' => 'البريد الإلكتروني لا يتطابق مع البريد الموثق.']);
        }
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
