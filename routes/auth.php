<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'register']);
