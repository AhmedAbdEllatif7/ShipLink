<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
