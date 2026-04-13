<?php

namespace App\Repositories\Dashboard\Merchant\Shipment;

use App\Models\Merchant;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Collection;

interface ShipmentRepositoryInterface
{
    public function getMerchantShipments(Merchant $merchant): Collection;

    public function store(array $data): Shipment;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
