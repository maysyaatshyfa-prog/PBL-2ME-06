<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomVariant;

class RoomVariantController extends Controller
{
    public function index(Request $request)
    {
        $query = RoomVariant::query();

        // FILTER CAPACITY (adult + child)
        if ($request->filled('adult') || $request->filled('child')) {
            $total = ($request->adult ?? 0) + ($request->child ?? 0);
            $query->where('capacity', '>=', $total);
        }

        // FILTER PRICE
        if ($request->filled('price')) {
            $query->where('price', '<=', $request->price);
        }

        // FILTER FACILITIES
        if ($request->filled('facilities')) {
            foreach ($request->facilities as $facility) {
                $query->where('facilities', 'LIKE', '%' . $facility . '%');
            }
        }

        $rooms = $query->get();

        // AMBIL FASILITAS UNIK 
        $allFacilities = collect($rooms)
            ->flatMap(function ($room) {
                return explode(',', $room->facilities ?? '');
            })
            ->map(fn($f) => trim($f))
            ->filter()
            ->unique()
            ->values();

        return view('rooms.index', [
            'rooms' => $rooms,
            'allFacilities' => $allFacilities
        ]);
    }

    public function show($id)
    {
        $variant = RoomVariant::with('room')->findOrFail($id);

        return view('rooms.detail', compact('variant'));
    }
}