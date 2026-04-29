<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomVariant extends Model
{
    protected $fillable = [
        'room_id',
        'name',
        'price',
        'capacity',
        'size',
        'image'
    ];
}