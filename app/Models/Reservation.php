<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'booking_code',
        'user_id',
        'branch_id',
        'package_id',
        'booking_date',
        'start_time',
        'end_time',
        'total_people',
        'total_price',
        'status',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function reservationAddons()
    {
        return $this->hasMany(ReservationAddon::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
