<?php

namespace App\Http\Controllers;

use App\Models\Reservation;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Reservation::with('room')->latest()->get();
        return view('bookinghistory', compact('bookings'));
    }
}
