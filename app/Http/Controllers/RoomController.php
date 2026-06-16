<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{

    public function type($typeKey)
    {
        return view('rooms.type', compact('typeKey'));
    }
}