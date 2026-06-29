<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomNumber extends Model
{
    protected $fillable = [
        'room_variant_id',
        'room_number',
        'floor',
        'status'
    ];

    public function variant()
    {
        return $this->belongsTo(
            RoomVariant::class,
            'room_variant_id'
        );
    }

  
    public function reservations()
    {
        return $this->hasMany(
            Reservation::class,
            'room_number_id'
        );
    }
}