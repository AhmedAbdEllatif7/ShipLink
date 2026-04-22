<?php

namespace App\Repositories\Dashboard\Admin\Shipment;

use App\Models\Shipment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ShipmentRepositoryInterface
{
    public function all(): LengthAwarePaginator;

    public function store(array $data): Shipment;

    public function update(int $id, array $data): bool;

    public function updateStatus(int $id, string $status, ?string $notes = null): bool;

    public function assignDriver(int $id, int $driverId): bool;

    public function delete(int $id): bool;

    public function find(int $id): ?Shipment;
}
