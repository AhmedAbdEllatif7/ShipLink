<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Shipment;
use App\Enums\ShipmentStatus;

class UserObserver
{
    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // 1. التعامل مع التاجر
        if ($user->merchant) {
            $merchant = $user->merchant;
            
            // نجلب الشحنات المعلقة للتاجر
            $pendingShipments = Shipment::where('merchant_id', $merchant->id)
                ->where('status', ShipmentStatus::PENDING)
                ->get();
            
            // نحذفها (Soft Delete) حتى لا تظل معلقة
            foreach ($pendingShipments as $shipment) {
                $shipment->delete();
            }

            // أخيراً نحذف بروفايل التاجر
            $merchant->delete();
        }

        // 2. التعامل مع السائق
        if ($user->driver) {
            $driver = $user->driver;

            // نجلب الشحنات المعينة له ولم يقم بتوصيلها بعد
            $assignedShipments = Shipment::where('driver_id', $driver->id)
                ->whereIn('status', [ShipmentStatus::ASSIGNED, ShipmentStatus::PICKED_UP])
                ->get();

            foreach ($assignedShipments as $shipment) {
                // سحب الشحنة من السائق المحذوف وإعادتها لقيد الانتظار
                $shipment->driver_id = null;
                $shipment->status = ShipmentStatus::PENDING;
                
                // We use 'status_notes' as a transient property to pass the reason to ShipmentObserver
                $shipment->status_notes = 'تم سحب الشحنة تلقائياً وإعادتها للانتظار بسبب حذف أو إيقاف حساب السائق.';
                $shipment->save();
            }

            // نحذف بروفايل السائق
            $driver->delete();
        }
    }
}
