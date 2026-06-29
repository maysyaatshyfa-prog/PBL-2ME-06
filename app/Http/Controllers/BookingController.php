<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\RoomNumber;
use App\Models\RoomVariant;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;
use Carbon\Carbon;

class BookingController extends Controller
{
    // =========================
    // CONFIRM BOOKING + SNAP
    // =========================
    public function confirm(Request $request)
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $variant = RoomVariant::findOrFail($request->room_variant_id);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);

        $duration = max(1, $checkIn->diffInDays($checkOut));
        $totalPrice = $variant->price * $duration;

        $orderId = 'RSV-' . time();

        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name ?? $request->nama,
                'email' => Auth::user()->email ?? $request->email,
                'phone' => $request->phone,
            ],
        ]);

        $roomNumber = RoomNumber::where('room_variant_id', $variant->id)
    ->whereDoesntHave('reservations', function ($q) use ($request) {
        $q->where('status', '!=', 'Batal')
          ->where(function ($query) use ($request) {
              $query->where('check_in', '<', $request->check_out)
                    ->where('check_out', '>', $request->check_in);
          });
    })
    ->first();

        if (!$roomNumber) {
            return back()->with('error', 'Kamar sudah penuh');
        }

        // =========================
        // SIMPAN RESERVATION
        // =========================
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'room_id' => $variant->room_id,
            'room_variant_id' => $variant->id,
            'room_number_id' => $roomNumber->id,

            'customer_name' => $request->nama,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'guest_name' => $request->guest_name,
            'special_request' => $request->special_request,

            'check_in' => $request->check_in,
            'check_out' => $request->check_out,

            'total_harga' => $totalPrice,

            'status_pembayaran' => 'Lunas',

            'order_id' => $orderId,
        ]);

        return view('konfirmasi', [
    'reservation' => $reservation,
    'snapToken'   => $snapToken,
    'variant'     => $variant,
    'duration'    => $duration,
    'totalPrice'  => $totalPrice,

    'checkin'     => $request->check_in,
    'checkout'    => $request->check_out,
    'adult'       => $request->adult,
    'child'       => $request->child,
]);
    }

    // =========================
    // MIDTRANS NOTIFICATION
    // =========================
    public function notification()
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');

        $notif = new \Midtrans\Notification();

        $orderId = $notif->order_id;
        $status = $notif->transaction_status;

       $reservation = Reservation::where('order_id', $orderId)->first();

if ($reservation) {

    $reservation->update([
        'status_pembayaran' => 'Lunas'
    ]);

    \App\Models\Payment::updateOrCreate(
        [
            'reservation_id' => $reservation->id
        ],
        [
            'order_id' => $reservation->order_id,
            'total_harga' => $reservation->total_harga,
            'status_pembayaran' => 'Lunas',
        ]
    );
}

        return response()->json(['status' => 'ok']);
    }

    // =========================
    // SUCCESS PAGE
    // =========================
    public function success()
    {
        $reservation = Reservation::where('user_id', Auth::id())
    ->latest()
    ->firstOrFail();

        if (!$reservation) {
            return redirect('/');
        }

        $reservation->update([
            'status_pembayaran' => 'Lunas'
        ]);

        \App\Models\Payment::updateOrCreate(
            ['reservation_id' => $reservation->id],
            [
                'status_pembayaran' => 'Lunas',
                'total_harga' => $reservation->total_harga,
            ]
        );

        $bookingCode = 'RSV-' . str_pad($reservation->id, 6, '0', STR_PAD_LEFT);

        return view('success', compact('reservation', 'bookingCode'));
    }

    //  BOOKING HISTORY     
public function index()
{
    $bookings = Reservation::with([
        'roomNumber.variant',
        'cancellation'
    ])
    ->where('user_id', Auth::id())
    ->latest()
    ->paginate(10);

    return view('bookinghistory', compact('bookings'));
}

public function show($id)
{
    $booking = Reservation::with([
        'roomNumber.variant',
        'user',
        'cancellation'
    ])
    ->where('id', $id)
    ->where('user_id', Auth::id())
    ->firstOrFail();

    return view('booking_detail', compact('booking'));
}

public function uploadKtp(Request $request, $id)
{
    $request->validate([
        'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $booking = Reservation::findOrFail($id);

    if ($request->hasFile('ktp')) {
        $file = $request->file('ktp');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->storeAs('ktp', $filename, 'public');

        $booking->ktp = $filename;
        $booking->save();
    }

    return back()->with('success', 'KTP berhasil diupload');
}

}