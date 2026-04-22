<?php

namespace App\Repositories\Dashboard\Merchant\Shipment;

use App\Models\Merchant;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ShipmentRepositoryInterface
{
    public function getMerchantShipments(Merchant $merchant): LengthAwarePaginator;

    public function store(array $data): Shipment;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
