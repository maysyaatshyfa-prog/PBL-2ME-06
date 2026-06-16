<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Reservation;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function pay($id)
{
    $reservation = Reservation::findOrFail($id);

    if ($reservation->total_price <= 0) {
        dd('TOTAL PRICE INVALID', $reservation->total_price);
    }

    $orderId = 'RSV-'.$reservation->id.'-'.time();
    $totalPrice = (int) $reservation->total_price;

    try {
        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name ?? 'Guest',
                'email'      => auth()->user()->email ?? 'guest@mail.com',
            ]
        ]);
    } catch (\Exception $e) {
        return "Gagal terhubung ke Midtrans: " . $e->getMessage();
    }

    return view('payment', compact('reservation', 'snapToken'));
}
}