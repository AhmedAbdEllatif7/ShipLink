<?php

namespace App\Traits;

use App\Models\Shipment;
use App\Models\ShipmentStatusHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait ShipmentRepositoryTrait
{
    /**
     * Generate a unique tracking number for a shipment.
     */
    protected function generateTrackingNumber(): string
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

    /**
     * Log a status change for a shipment.
     */
    protected function logStatusChange(int $shipmentId, string $status, ?string $notes = null): void
    {
        ShipmentStatusHistory::create([
            'shipment_id' => $shipmentId,
            'status' => $status,
            'changed_by' => Auth::id(),
            'notes' => $notes,
        ]);
    }
}
