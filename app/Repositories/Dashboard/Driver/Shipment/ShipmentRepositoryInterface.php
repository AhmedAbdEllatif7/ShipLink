<?php

namespace App\Repositories\Dashboard\Driver\Shipment;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Collection;

interface ShipmentRepositoryInterface
{
    public function getDriverShipments(Driver $driver): Collection;

    public function updateStatus(int $id, string $status, ?string $notes = null): bool;
}
