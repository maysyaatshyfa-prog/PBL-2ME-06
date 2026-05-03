<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_variant_id',
        'number',
        'status'
    ];

    public function variant()
    {
        return $this->belongsTo(RoomVariant::class, 'room_variant_id');
    }
}