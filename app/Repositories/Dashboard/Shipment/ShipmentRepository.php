<?php

namespace App\Repositories\Dashboard\Shipment;

use App\Models\Merchant;
use App\Enums\ShipmentStatus;
use App\Models\Shipment;
use App\Models\ShipmentStatusHistory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShipmentRepository implements ShipmentRepositoryInterface
{
    public function all(): Collection
    {
        return Shipment::with(['merchant.user', 'driver.user'])->latest()->get();
    }


    public function getMerchantShipments(Merchant $merchant): Collection
    {
        return Shipment::whereBelongsTo($merchant)->latest()->get();
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

    private function generateTrackingNumber(): string
    {
        $prefix = 'SHP-';
        $random = strtoupper(Str::random(10));
        $trackingNumber = $prefix . $random;

        // Ensure uniqueness
        while (Shipment::where('tracking_number', $trackingNumber)->exists()) {
            $trackingNumber = $prefix . strtoupper(Str::random(10));
        }

        return $trackingNumber;
    }

    private function logStatusChange(int $shipmentId, string $status, ?string $notes = null): void
    {
        ShipmentStatusHistory::create([
            'shipment_id' => $shipmentId,
            'status' => $status,
            'changed_by' => Auth::id(),
            'notes' => $notes,
        ]);
    }
}
