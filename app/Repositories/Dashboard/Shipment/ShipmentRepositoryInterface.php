<?php

namespace App\Repositories\Dashboard\Shipment;

use App\Models\Shipment;
use Illuminate\Database\Eloquent\Collection;

interface ShipmentRepositoryInterface
{
    public function all(): Collection;
    
    public function find(int $id): ?Shipment;
    
    public function getMerchantShipments(int $merchantId): Collection;
    
    public function store(array $data): Shipment;
    
    public function update(int $id, array $data): bool;
    
    public function updateStatus(int $id, string $status, ?string $notes = null): bool;
    
    public function assignDriver(int $id, int $driverId): bool;
    
    public function delete(int $id): bool;
}
