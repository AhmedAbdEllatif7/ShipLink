<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/track', [HomeController::class, 'track'])->name('home.track');

Route::get('/dashboard', function () {
    $type = auth()->user()->type->value;
    return match ($type) {
        'admin' => redirect()->route('admin.dashboard'),
        'merchant' => redirect()->route('merchant.dashboard'),
        'driver' => redirect()->route('driver.dashboard'),
        default => redirect('/'),
    };
})->middleware(['auth'])->name('dashboard');

