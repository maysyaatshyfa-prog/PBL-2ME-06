<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'reservation_id',
        'order_id',
        'total_harga',
        'status_pembayaran',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}