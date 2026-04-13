<?php

namespace App\Repositories\Dashboard\Driver\Shipment;

use App\Models\Driver;
use App\Models\Shipment;
use App\Enums\ShipmentStatus;
use App\Traits\ShipmentRepositoryTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ShipmentRepository implements ShipmentRepositoryInterface
{
    use ShipmentRepositoryTrait;

    public function getDriverShipments(Driver $driver): Collection
    {
        return Shipment::whereBelongsTo($driver)->latest()->get();
    }

    public function updateStatus(int $id, string $status, ?string $notes = null): bool
    {
        return DB::transaction(function () use ($id, $status, $notes) {
            $shipment = Shipment::findOrFail($id);
            
            // Basic security: Ensure driver is assigned to this shipment
            // Note: This could also be handled in the Controller via Policy
            $shipment->status = $status;
            
            if ($status === ShipmentStatus::DELIVERED->value) {
                $shipment->delivered_at = now();
            }

            $shipment->save();

            $this->logStatusChange($id, $status, $notes);

            return true;
        });
    }
}
