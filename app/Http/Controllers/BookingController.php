<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Reservation::with('room')->latest()->get();
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