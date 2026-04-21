<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'tracking_number',
        'merchant_id',
        'driver_id',
        'status',
        'receiver_name',
        'receiver_phone',
        'receiver_address',
        'city',
        'cod_amount',
        'assigned_at',
        'delivered_at',
    ];

    protected $casts = [
        'status' => \App\Enums\ShipmentStatus::class,
        'assigned_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * Transient property used to pass temporary status notes between observers 
     * (e.g., from UserObserver to ShipmentObserver). This value is NOT saved 
     * to the shipments table but is persisted in ShipmentStatusHistory@notes.
     */
    public ?string $status_notes = null;

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(ShipmentStatusHistory::class);
    }
}
