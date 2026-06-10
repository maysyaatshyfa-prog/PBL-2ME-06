<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'type',
        'title',
        'description',
        'status'
    ];

    public function reservations()
    {
        return $this->hasMany(
            Reservation::class,
            'room_id'
        );
    }

    public function variants()
{
    return $this->hasMany(RoomVariant::class);
}
public function firstVariant()
{
    return $this->hasOne(RoomVariant::class);
}
}