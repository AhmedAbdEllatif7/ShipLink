<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'loginStore']);

    // Pre-Registration Email & OTP
    Route::get('register/email', [AuthController::class, 'requestEmail'])->name('register.email');
    Route::post('register/email', [AuthController::class, 'sendOtp'])->name('register.send-otp');
    
    Route::get('register/verify-otp', [AuthController::class, 'verifyOtpForm'])->name('register.verify-otp');
    Route::post('register/verify-otp', [AuthController::class, 'verifyOtp'])->name('register.verify-otp.submit');

    // Registration (Final Step)
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'registerStore'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'destroy'])->name('logout');
});
