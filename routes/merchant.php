<?php

use App\Http\Controllers\Merchant\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('merchant.dashboard');

// Additional Merchant routes will go here
