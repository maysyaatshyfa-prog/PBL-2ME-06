<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class BookingController extends Controller
{
   public function index()
{
    $bookings = [
        (object)[
            'id' => 1,
            'checkin' => '2026-05-10',
            'checkout' => '2026-05-12',
            'status' => 'Proses',
            'payment_status' => 'Belum Bayar',
            'room' => (object)[
                'name' => 'Deluxe Room'
            ]
        ]
    ];

    return view('bookinghistory', compact('bookings'));
}

    public function create($id)
    {
        return view('booking.create', compact('id'));
    }

    public function confirm(Request $request)
    {
        return view('booking.confirm', compact('request'));
    }

    public function payment()
    {
        return view('booking.payment');
    }

    public function success()
    {
        return view('booking.success');
    }
    
}