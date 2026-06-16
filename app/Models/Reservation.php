<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Room;
use App\Models\RoomNumber;

class Reservation extends Model {
    protected $fillable=[ 'user_id',
    'room_id',
    'room_number_id',
    'check_in',
    'check_out',
    'total_harga',
    'status',
    'status_pembayaran',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function roomVariant() {
        return $this->belongsTo(RoomVariant::class, 'room_id');
    }

    public function roomNumber() {
        return $this->belongsTo(RoomNumber::class,
            'room_number_id'
        );
    }
}