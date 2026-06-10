<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomVariant;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function form(Request $request)
    {
        $variant = RoomVariant::findOrFail($request->query('variant_id'));

        $checkin = $request->query('checkin');
        $checkout = $request->query('checkout');
        $adult = $request->query('adult', 2);
        $child = $request->query('child', 0);

        $dateIn = Carbon::parse($checkin);
        $dateOut = Carbon::parse($checkout);

        $duration = max(1, $dateIn->diffInDays($dateOut));
        $totalPrice = $variant->price * $duration;

        return view('form-reservasi', compact(
            'variant',
            'checkin',
            'checkout',
            'adult',
            'child',
            'duration',
            'totalPrice'
        ));
    }

    public function konfirmasi(Request $request)
    {
        $variant = RoomVariant::findOrFail($request->query('variant_id'));

        $checkin = $request->query('checkin');
        $checkout = $request->query('checkout');
        $adult = $request->query('adult', 2);
        $child = $request->query('child', 0);

        $dateIn = Carbon::parse($checkin);
        $dateOut = Carbon::parse($checkout);

        $duration = max(1, $dateIn->diffInDays($dateOut));
        $totalPrice = $variant->price * $duration;

        return view('konfirmasi', compact(
            'variant',
            'checkin',
            'checkout',
            'adult',
            'child',
            'duration',
            'totalPrice'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_variant_id' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $variant = RoomVariant::findOrFail($request->room_variant_id);

        $dateIn = Carbon::parse($request->check_in);
        $dateOut = Carbon::parse($request->check_out);

        $duration = max(1, $dateIn->diffInDays($dateOut));
        $totalPrice = $variant->price * $duration;

        Reservation::create([
            'user_id' => auth()->id(),
            'room_variant_id' => $variant->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'adult' => $request->adult,
            'child' => $request->child,
            'duration' => $duration,
            'total_price' => $totalPrice,
            'status' => 'menunggu'
        ]);

        return redirect()->route('reservasi.index')
            ->with('success', 'Reservasi berhasil dibuat');
    }

    public function index()
    {
        $reservations = Reservation::with(['user', 'roomVariant'])->latest()->get();

        return view('admin.reservasi', compact('reservations'));
    }
}