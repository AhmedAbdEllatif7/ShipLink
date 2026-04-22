<?php

namespace App\Repositories\Dashboard\Admin\Shipment;

use App\Models\Shipment;
use App\Enums\ShipmentStatus;
use Illuminate\Database\Eloquent\Collection;

class ShipmentRepository implements ShipmentRepositoryInterface
{

    public function all(): Collection
    {
        return Shipment::with(['merchant.user', 'driver.user'])->latest()->get();
    }

    /**
     * @NOTE: 'tracking_number' and initial 'PENDING' status are 
     * generated automatically via ShipmentObserver@creating.
     */
    public function store(array $data): Shipment
    {
        return Shipment::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $shipment = Shipment::findOrFail($id);
        return $shipment->update($data);
    }

    /**
     * @NOTE: Observer handles updating 'delivered_at' timestamp 
     * and strictly prevents modifications to DELIVERED shipments.
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

    /**
     * @NOTE: Observer automatically sets 'assigned_at' timestamp 
     * and logs the driver assignment to the ShipmentStatusHistory.
     */
    public function assignDriver(int $id, int $driverId): bool
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->driver_id = $driverId;
        $shipment->status = ShipmentStatus::ASSIGNED;
        return $shipment->save();
    }

    /**
     * @NOTE: Observer hooks into 'deleted' to log SoftDelete history, 
     * or fully clean up history if ForceDeleted.
     */
    public function delete(int $id): bool
    {
        $shipment = Shipment::findOrFail($id);
        return $shipment->delete();
    }

    public function find(int $id): ?Shipment
    {
        return Shipment::with([
            'merchant.user',
            'driver.user',
            'statusHistories.user'
        ])->findOrFail($id);
    }
}
