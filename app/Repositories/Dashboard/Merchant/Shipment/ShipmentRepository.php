<?php

namespace App\Repositories\Dashboard\Merchant\Shipment;

use App\Models\Merchant;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ShipmentRepository implements ShipmentRepositoryInterface
{

    public function getMerchantShipments(Merchant $merchant): LengthAwarePaginator
    {
        return Shipment::whereBelongsTo($merchant)->latest()->paginate(config('shiplink.pagination_limit', 10));
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
