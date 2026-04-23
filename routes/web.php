<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $type = auth()->user()->type->value;
    return match ($type) {
        'admin' => redirect()->route('admin.dashboard'),
        'merchant' => redirect()->route('merchant.dashboard'),
        'driver' => redirect()->route('driver.dashboard'),
        default => redirect('/'),
    };
})->middleware(['auth'])->name('dashboard');

