<?php

use App\Http\Controllers\Dashboard\Merchant\MerchantShipmentController;
use App\Http\Controllers\Dashboard\Merchant\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('merchant.dashboard');

// Shipment CRUD
Route::resource('shipments', MerchantShipmentController::class)->names([
    'index' => 'merchant.shipments.index',
    'create' => 'merchant.shipments.create',
    'store' => 'merchant.shipments.store',
    'show' => 'merchant.shipments.show',
    'edit' => 'merchant.shipments.edit',
    'update' => 'merchant.shipments.update',
    'destroy' => 'merchant.shipments.destroy',
]);
