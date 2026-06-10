<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

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

    // DETAIL KAMAR (INI YANG BENAR)
    public function show($id)
{
    $room = Room::with('variants')->findOrFail($id);

    return view('rooms.detail', compact('room'));
}

    public function type($typeKey)
    {
        return view('rooms.type', compact('typeKey'));
    }
}