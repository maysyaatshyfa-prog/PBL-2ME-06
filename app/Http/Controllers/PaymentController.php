<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Reservation;

class PaymentController extends Controller
{
    public function pay($id)
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $reservation = Reservation::findOrFail($id);

        $orderId = 'RSV-'.$reservation->id.'-'.time();
        $totalPrice = (int) $reservation->total_harga;

        $name = $reservation->customer_name;
        $email = $reservation->customer_email;
        $phone = $reservation->customer_phone;

        try {
            $snapToken = Snap::getSnapToken([
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                ],
                'enabled_payments' => [
                    'bank_transfer',
                    'gopay',
                    'qris'
                ],
            ]);
        } catch (\Exception $e) {
            return "Gagal Midtrans: ".$e->getMessage();
        }

        return view('payment', compact('reservation', 'snapToken'));
    }
}