<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Shipment;
use App\Enums\ShipmentStatus;

class UserObserver
{
  public function deleted(User $user): void
    {
        $this->handleMerchantDeletion($user);
        $this->handleDriverDeletion($user);
    }

    private function handleMerchantDeletion(User $user): void
    {
        if (!$user->merchant) {
            return;
        }

        $merchant = $user->merchant;

        $this->deletePendingShipmentsForMerchant($merchant->id);

        $merchant->delete();
    }

    private function deletePendingShipmentsForMerchant(int $merchantId): void
    {
        Shipment::where('merchant_id', $merchantId)
            ->where('status', ShipmentStatus::PENDING)
            ->each(fn($shipment) => $shipment->delete());
    }

    private function handleDriverDeletion(User $user): void
    {
        if (!$user->driver) {
            return;
        }

        $driver = $user->driver;

        $this->releaseDriverShipments($driver->id);

        $driver->delete();
    }

    private function releaseDriverShipments(int $driverId): void
    {
        Shipment::where('driver_id', $driverId)
            ->whereIn('status', [
                ShipmentStatus::ASSIGNED,
                ShipmentStatus::PICKED_UP
            ])
            ->each(function ($shipment) {
                $shipment->update([
                    'driver_id' => null,
                    'status' => ShipmentStatus::PENDING,
                    'status_notes' => 'تم سحب الشحنة تلقائياً وإعادتها للانتظار بسبب حذف أو إيقاف حساب السائق.'
                ]);
            });
    }

}
