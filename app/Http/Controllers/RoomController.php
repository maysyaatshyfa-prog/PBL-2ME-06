<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $checkin = $request->checkin;
        $checkout = $request->checkout;
        $adult = $request->adult;
        $child = $request->child;

        return view('rooms.index', compact('rooms'));
    }

    public function type($typeKey)
    {
        return view('rooms.type', compact('typeKey'));
    }
}