<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cancellation extends Model {
    protected $fillable = [
    'reservation_id',
    'reason',
    'other_reason',
    'status'
];

    public function reservation() {
        return $this->belongsTo(Reservation::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
} 