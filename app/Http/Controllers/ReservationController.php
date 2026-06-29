<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomVariant;
use App\Models\RoomNumber;
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

        $roomNumber = RoomNumber::where('room_variant_id', $variant->id)
            ->where('status', 'tersedia')
            ->first();

        if (!$roomNumber) {
            return back()->with('error', 'Tidak ada kamar tersedia');
        }

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'room_id' => $variant->id,
            'room_variant_id' => $variant->id,
            'room_number_id' => $roomNumber->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_harga' => $totalPrice,
            'status' => 'Menunggu Pembayaran',
            'status_pembayaran' => 'Belum Bayar'
        ]);

        $roomNumber->update([
            'status' => 'terisi'
        ]);

        return redirect()->route('reservasi.index')
            ->with('success', 'Reservasi berhasil dibuat');
    }
}