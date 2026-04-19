<?php

namespace App\Repositories\Dashboard\Admin\Shipment;

use App\Models\Shipment;
use App\Enums\ShipmentStatus;
use App\Traits\ShipmentRepositoryTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ShipmentRepository implements ShipmentRepositoryInterface
{
    use ShipmentRepositoryTrait;

    public function all(): Collection
    {
        return Shipment::with(['merchant.user', 'driver.user'])->latest()->get();
    }

    public function store(array $data): Shipment
    {
        return DB::transaction(function () use ($data) {
            $data['tracking_number'] = $this->generateTrackingNumber();
            $data['status'] = ShipmentStatus::PENDING;

            $shipment = Shipment::create($data);

            // Log initial status
            $this->logStatusChange($shipment->id, ShipmentStatus::PENDING->value, 'تم إنشاء الشحنة');

            
            return $shipment;
        });
    }

    public function update(int $id, array $data): bool
    {
        $shipment = Shipment::findOrFail($id);
        return $shipment->update($data);
    }

    public function updateStatus(int $id, string $status, ?string $notes = null): bool
    {
        return DB::transaction(function () use ($id, $status, $notes) {
            $shipment = Shipment::findOrFail($id);
            $shipment->status = $status;
            
            if ($status === ShipmentStatus::DELIVERED->value) {
                $shipment->delivered_at = now();
            }

            $shipment->save();

            $this->logStatusChange($id, $status, $notes);

            return true;
        });
    }

    public function assignDriver(int $id, int $driverId): bool
    {
        return DB::transaction(function () use ($id, $driverId) {
            $shipment = Shipment::findOrFail($id);
            $shipment->driver_id = $driverId;
            $shipment->status = ShipmentStatus::ASSIGNED;
            $shipment->assigned_at = now();
            $shipment->save();

            $this->logStatusChange($id, ShipmentStatus::ASSIGNED->value, 'تم تعيين سائق للشحنة');

            return true;
        });
    }

    public function delete(int $id): bool
    {
        $shipment = Shipment::findOrFail($id);
        return $shipment->delete();
    }
}
