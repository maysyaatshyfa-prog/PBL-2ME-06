<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\RoomVariant;

class RoomVariantController extends Controller
{
    public function index(Request $request)
    {
        $query = RoomVariant::query();

        // FILTER JUMLAH TAMU
        if ($request->filled('adult') || $request->filled('child')) {

            $totalGuest = ($request->adult ?? 0) + ($request->child ?? 0);

            $query->where('capacity', '>=', $totalGuest);
        }

        // FILTER HARGA
        if ($request->filled('min_price') && $request->filled('max_price')) {

            $query->whereBetween('price', [
                $request->min_price,
                $request->max_price
            ]);
        }

        // FILTER FASILITAS
        if ($request->filled('facilities')) {

            foreach ($request->facilities as $facility) {

                $query->where('facilities', 'LIKE', '%' . $facility . '%');

            }

        }

        // DATA HASIL FILTER
        $rooms = $query->get();

        // AMBIL SEMUA FASILITAS DARI DATABASE
        $allFacilities = RoomVariant::all()
            ->flatMap(function ($room) {
                return explode(',', $room->facilities ?? '');
            })
            ->map(fn ($facility) => trim($facility))
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('rooms.index', compact(
            'rooms',
            'allFacilities'
        ));
    }

    public function show($id)
{
    $variant = RoomVariant::with('room')->findOrFail($id);

    return view('rooms.detail', compact('variant'));
}

public function type($type)
{
    $room = Room::where('type', $type)->firstOrFail();

    $variants = RoomVariant::where('room_id', $room->id)->get();

    return view('rooms.type', [
        'room' => $room,
        'variants' => $variants,
        'typeKey' => $type
    ]);
}

    
}