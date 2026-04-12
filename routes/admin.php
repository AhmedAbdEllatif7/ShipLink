<?php

use App\Http\Controllers\Dashboard\Admin\DashboardController;
use App\Http\Controllers\Dashboard\Admin\RoleController;
use App\Http\Controllers\Dashboard\Admin\PermissionController;
use App\Http\Controllers\Dashboard\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

// Roles Management
Route::resource('roles', RoleController::class)->names([
    'index' => 'admin.roles.index',
    'create' => 'admin.roles.create',
    'store' => 'admin.roles.store',
    'show' => 'admin.roles.show',
    'edit' => 'admin.roles.edit',
    'update' => 'admin.roles.update',
    'destroy' => 'admin.roles.destroy',
]);

// Permissions management (Read-only view)
Route::resource('permissions', PermissionController::class)->names([
    'index' => 'admin.permissions.index',
])->only(['index']);

// Users management
Route::resource('users', UserController::class)->names([
    'index' => 'admin.users.index',
    'create' => 'admin.users.create',
    'store' => 'admin.users.store',
    'show' => 'admin.users.show',
    'edit' => 'admin.users.edit',
    'update' => 'admin.users.update',
    'destroy' => 'admin.users.destroy',
]);
