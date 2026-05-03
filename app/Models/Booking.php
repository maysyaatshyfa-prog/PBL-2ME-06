<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'checkin',
        'checkout',
        'adult',
        'child',
        'total_price',
        'status'
    ];
}