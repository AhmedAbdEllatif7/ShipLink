<?php

namespace App\Repositories\Dashboard\Driver\Shipment;

use App\Models\Driver;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ShipmentRepository implements ShipmentRepositoryInterface
{

    public function getDriverShipments(Driver $driver): LengthAwarePaginator
    {
        return Shipment::with('merchant')->whereBelongsTo($driver)->latest()->paginate(config('shiplink.pagination_limit', 10));
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

    public function find(int $id): ?Shipment
    {
        return Shipment::with(['statusHistories.user'])->findOrFail($id);
    }
}
