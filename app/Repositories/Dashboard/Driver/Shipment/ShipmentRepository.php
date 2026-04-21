<?php

namespace App\Repositories\Dashboard\Driver\Shipment;

use App\Models\Driver;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Collection;

class ShipmentRepository implements ShipmentRepositoryInterface
{

    public function getDriverShipments(Driver $driver): Collection
    {
        return Shipment::whereBelongsTo($driver)->latest()->get();
    }


    /**
     * @NOTE: Preventing modifications to DELIVERED shipments 
     * and history logging are strictly enforced in ShipmentObserver.
     */
    public function updateStatus(int $id, string $status, ?string $notes = null): bool
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->status = $status;
        if ($notes) {
            $shipment->status_notes = $notes;
        }
        return $shipment->save();
    }
}
