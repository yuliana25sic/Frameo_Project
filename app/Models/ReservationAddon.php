<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationAddon extends Model
{
    protected $fillable = [
        'reservation_id',
        'addon_id',
        'quantity',
        'subtotal',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function addon()
    {
        return $this->belongsTo(Addon::class);
    }
}
