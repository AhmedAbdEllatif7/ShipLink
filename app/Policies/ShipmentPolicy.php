<?php

namespace App\Policies;

use App\Models\Shipment;
use App\Models\User;
use App\Enums\ShipmentStatus;

class ShipmentPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole(['super_admin', 'admin'])) {
            return true;
        }

        return null;
    }


    public function view(User $user, Shipment $shipment): bool
    {
        return $user->merchant && $shipment->merchant_id === $user->merchant->id;
    }


    public function create(User $user): bool
    {
        return $user->merchant !== null;
    }

    public function update(User $user, Shipment $shipment): bool
    {
        return $user->merchant && 
               $shipment->merchant_id === $user->merchant->id && 
               $shipment->status === ShipmentStatus::PENDING;
    }

    public function delete(User $user, Shipment $shipment): bool
    {
        return $user->merchant && 
               $shipment->merchant_id === $user->merchant->id && 
               $shipment->status === ShipmentStatus::PENDING;
    }
}
