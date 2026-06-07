<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\RoomVariant;
use Midtrans\Snap;
use Midtrans\Config;
use Carbon\Carbon;

class BookingController extends Controller
{
   public function index()
{
    $bookings = [
       
    ];

    return view('bookinghistory', compact('bookings'));
}

    public function create($id)
    {
        return view('booking.create', compact('id'));
    }

     public function confirm(Request $request)
{
    // MIDTRANS CONFIG (WAJIB dari ENV)
    Config::$serverKey = config('midtrans.serverKey');
    Config::$isProduction = config('midtrans.isProduction');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $variant = RoomVariant::findOrFail($request->room_variant_id);

$checkin = $request->check_in;
$checkout = $request->check_out;

$adult = $request->adult;
$child = $request->child;
    $nama = $request->nama;
    $email = $request->email;
    $phone = $request->phone;
    $guest_name = $request->guest_name;
    $special_request = $request->special_request;

    $dateIn = Carbon::parse($checkin);
    $dateOut = Carbon::parse($checkout);

    $duration = max(1, $dateIn->diffInDays($dateOut));
    $totalPrice = $variant->price * $duration;

    // 🔥 VALIDASI PENTING
    if ($totalPrice <= 0) {
        return "Total harga tidak valid";
    }

    try {
        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => 'BOOK-' . time(),
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name ?? 'Guest',
                'email' => auth()->user()->email ?? 'guest@mail.com',
            ]
        ]);
    } catch (\Exception $e) {
        return "Midtrans Error: " . $e->getMessage();
    }

    return view('konfirmasi', compact(
        'variant',
        'checkin',
        'checkout',
        'adult',
        'child',
        'duration',
        'totalPrice',
        'snapToken'
    ));
}


    public function payment()
    {
        return view('booking.payment');
    }

    public function success()
    {
        $bookingCode = 'BOOK-' . date('YmdHis');
        return view('success', compact('bookingCode'));
    }
    
}