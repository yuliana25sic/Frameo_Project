<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'open_time',
        'close_time',
        'is_active',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
