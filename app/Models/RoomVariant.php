<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
use App\Models\RoomNumber;

class RoomVariant extends Model
{
    protected $fillable = [
    'room_id',
    'name',
    'price',
    'description',
    'capacity',
    'size',
    'image',
    'gallery',
    'bed_type',
    'room_view',
    'facilities'
];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function roomNumbers()
{
    return $this->hasMany(
        RoomNumber::class,
        'room_variant_id'
    );
}

public function type($type)
{
    $rooms = RoomVariant::where('slug', $type)->get();

    return view('rooms.type', compact('rooms'));
}

}