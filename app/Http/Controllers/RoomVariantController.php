<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; 
use App\Models\RoomVariant;
use Illuminate\Http\Request;

class RoomVariantController extends Controller
{
  public function index(Request $request)
{
    $query = RoomVariant::query();

    if ($request->adult || $request->child) {
        $total = ($request->adult ?? 0) + ($request->child ?? 0);
        $query->where('capacity', '>=', $total);
    }

    if ($request->price) {
        $query->where('price', '<=', $request->price);
    }

    $rooms = $query->get();

    return view('rooms.index', compact('rooms'));
}
}