<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return view('rooms');
    }

    public function detail($id)
    {
        return view('room_detail', compact('id'));
    }
}
