<?php

namespace App\Repositories\Dashboard\Merchant\Shipment;

use App\Models\Merchant;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Collection;

class ShipmentRepository implements ShipmentRepositoryInterface
{

    public function getMerchantShipments(Merchant $merchant): Collection
    {
        return Shipment::whereBelongsTo($merchant)->latest()->get();
    }

    public function store(array $data): Shipment
    {
        /**
         * @NOTE: 'tracking_number' and initial 'PENDING' status are 
         * generated automatically via ShipmentObserver@creating.
         * Also, the initial history log is created via ShipmentObserver@created.
         */
        return Shipment::create($data);
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
