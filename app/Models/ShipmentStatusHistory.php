<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipmentStatusHistory extends Model
{
    use SoftDeletes;
    public $timestamps = false; // We use created_at only

    protected $fillable = [
        'shipment_id',
        'status',
        'changed_by',
        'notes',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
