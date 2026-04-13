<?php

namespace App\Repositories\Dashboard\Merchant\Shipment;

use App\Models\Merchant;
use App\Models\Shipment;
use App\Enums\ShipmentStatus;
use App\Traits\ShipmentRepositoryTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ShipmentRepository implements ShipmentRepositoryInterface
{
    use ShipmentRepositoryTrait;

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

    public function delete(int $id): bool
    {
        $shipment = Shipment::findOrFail($id);
        return $shipment->delete();
    }
}
