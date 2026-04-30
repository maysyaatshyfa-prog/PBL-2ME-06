<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomVariant;

class RoomController extends Controller
{
    // LIST KAMAR
    public function index(Request $request)
    {
        $rooms = Room::all();

        $checkin = $request->checkin;
        $checkout = $request->checkout;
        $adult = $request->adult;
        $child = $request->child;

        return view('rooms.index', compact('rooms', 'checkin', 'checkout', 'adult', 'child'));
    }

    // DETAIL KAMAR
   public function show($id)
   {
       $variant = RoomVariant::with('room')->findOrFail($id);

       return view('room-detail', compact('variant'));
    }

    // TYPE (opsional)
    public function type($typeKey)
    {
        return view('rooms.type', compact('typeKey'));
    }
}