<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Room;
use App\Models\RoomNumber;
use App\Models\Cancellation;

class Reservation extends Model {
    protected $fillable = [
    'user_id',
    'room_id',
    'room_variant_id',
    'room_number_id',
    'ktp',

    'customer_name',
    'customer_email',
    'customer_phone',

    'guest_name',
    'special_request',

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
        return $this->belongsTo(RoomVariant::class, 'room_variant_id');
    }

    public function roomNumber() {
        return $this->belongsTo(RoomNumber::class,
            'room_number_id'
        );
    }

    public function cancellation()
{
    return $this->hasOne(Cancellation::class, 'reservation_id');
}
}