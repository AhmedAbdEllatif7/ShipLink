<?php

namespace App\Repositories\Dashboard\Driver\Shipment;

use App\Models\Driver;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ShipmentRepositoryInterface
{
    public function getDriverShipments(Driver $driver): LengthAwarePaginator;

    public function updateStatus(int $id, string $status, ?string $notes = null): bool;

    public function find(int $id): ? Shipment;
}
