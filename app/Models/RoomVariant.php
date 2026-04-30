<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;

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

    
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}