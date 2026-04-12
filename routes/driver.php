<?php

use App\Http\Controllers\Dashboard\Driver\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('driver.dashboard');

// Additional Driver routes will go here
