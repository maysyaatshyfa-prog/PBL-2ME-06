<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return view('rooms.index'); 
    }

    public function type($typeKey)
{
    return view('rooms.type', compact('typeKey'));
}
}