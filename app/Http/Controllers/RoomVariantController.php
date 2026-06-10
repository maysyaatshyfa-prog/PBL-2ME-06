<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomVariant;

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

    public function show($id)
    {
        $variant = RoomVariant::with('room')->findOrFail($id);

        return view('rooms.detail', compact('variant'));
    }
}