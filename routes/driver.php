<?php

use App\Http\Controllers\Dashboard\Driver\DashboardController;
use App\Http\Controllers\Dashboard\Driver\DriverShipmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('driver.dashboard');

// Driver Shipments
Route::prefix('shipments')->group(function () {
    Route::get('/', [DriverShipmentController::class, 'index'])->name('driver.shipments.index');
    Route::get('{id}', [DriverShipmentController::class, 'show'])->name('driver.shipments.show');
    Route::post('{id}/status', [DriverShipmentController::class, 'updateStatus'])->name('driver.shipments.update-status');
});
