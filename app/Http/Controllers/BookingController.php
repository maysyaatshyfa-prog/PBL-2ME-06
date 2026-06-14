<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\RoomNumber;
use App\Models\RoomVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
{
    $bookings = Reservation::with([
    'room',
    'roomNumber.variant'
])
->where('user_id', Auth::id())
->latest()
->get();

    return view('bookinghistory', compact('bookings'));
}

    public function show($id)
{
    $booking = Reservation::with([
        'room.firstVariant',
        'user'
    ])
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    return view('booking_detail', compact('booking'));
}

    public function cancel($id)
    {
        $booking = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $booking->update([
            'status' => 'Batal'
        ]);

        return redirect()->back()
            ->with('success', 'Reservasi berhasil dibatalkan.');
    }

    public function create($id)
    {
        return view('booking.create', compact('id'));
    }

    public function confirm(Request $request)
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $variant = RoomVariant::findOrFail($request->room_variant_id);

        $dateIn = Carbon::parse($request->check_in);
        $dateOut = Carbon::parse($request->check_out);

        $duration = max(1, $dateIn->diffInDays($dateOut));
        $totalPrice = $variant->price * $duration;

        $checkin = $request->check_in;
        $checkout = $request->check_out;
        $adult = $request->adult;
        $child = $request->child;

        $user = Auth::user();

        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => 'BOOK-' . time(),
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ]
        ]);

        session([
            'room_id' => $variant->room_id,
            'check_in' => $checkin,
            'check_out' => $checkout,
            'total_harga' => $totalPrice,
        ]);

        return view('konfirmasi', compact(
            'variant',
            'duration',
            'totalPrice',
            'snapToken',
            'checkin',
            'checkout',
            'adult',
            'child'
        ));
    }

    public function payment()
    {
        return view('booking.payment');
    }

    public function success()
{
    $roomId = session('room_id');

    $variant = RoomVariant::where(
        'room_id',
        $roomId
    )->first();

    $roomNumber = RoomNumber::where(
            'room_variant_id',
            $variant->id
        )
        ->where('status', 'tersedia')
        ->first();

    if (!$roomNumber) {

        return redirect('/')
            ->with(
                'error',
                'Kamar sudah penuh'
            );
    }

    $roomNumber->update([
        'status' => 'terisi'
    ]);

    $reservation = Reservation::create([
        'user_id'            => Auth::id(),
        'room_id'            => $roomId,
        'room_number_id'     => $roomNumber->id,
        'check_in'           => session('check_in'),
        'check_out'          => session('check_out'),
        'total_harga'        => session('total_harga'),
        'status'             => 'Dalam Proses',
        'status_pembayaran'  => 'Lunas',
    ]);

    $bookingCode = 'RSV-' . str_pad(
        $reservation->id,
        6,
        '0',
        STR_PAD_LEFT
    );

    return view(
        'success',
        compact(
            'reservation',
            'bookingCode'
        )
    );
}

    public function storePayment(Request $request, $id)
    {
        return redirect()->route('payment.success');
    }
}