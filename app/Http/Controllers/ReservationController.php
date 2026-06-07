<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomVariant;
<<<<<<< HEAD
use App\Models\Room; // Ditambahkan untuk memanggil model Room induk
use App\Models\Reservation; 
=======
use App\Models\Reservation;
use Midtrans\Snap;
use Midtrans\Config;
>>>>>>> 09e1eec032c5730b60808b865c8bb66b85864c86
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

<<<<<<< HEAD
        // pastikan tanggal valid
=======
>>>>>>> 09e1eec032c5730b60808b865c8bb66b85864c86
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
    // MIDTRANS CONFIG (WAJIB dari ENV)
    Config::$serverKey = config('midtrans.serverKey');
    Config::$isProduction = config('midtrans.isProduction');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $variant = RoomVariant::findOrFail($request->query('variant_id'));

    $checkin = $request->query('checkin');
    $checkout = $request->query('checkout');
    $adult = $request->query('adult', 2);
    $child = $request->query('child', 0);

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

    public function store(Request $request)
    {
        // 1. Ambil data varian untuk menghitung harga
        $variant = RoomVariant::findOrFail($request->room_variant_id);

        $dateIn = Carbon::parse($request->check_in);
        $dateOut = Carbon::parse($request->check_out);

        $duration = max(1, $dateIn->diffInDays($dateOut));
        $totalPrice = $variant->price * $duration;

        // 2. Simpan ke database sesuai dengan kolom tabel reservations kamu
        Reservation::create([
            'user_id'     => auth()->id(),
            'room_id'     => $variant->room_id, // Mengambil room_id dari varian kamar agar cocok dengan database
            'check_in'    => $request->check_in,
            'check_out'   => $request->check_out,
            'total_harga' => $totalPrice, // Disesuaikan dari total_price menjadi total_harga
            'status'      => 'Menunggu Pembayaran' // Disesuaikan dengan default string status sistem kita
        ]);

        // 3. Alihkan halaman ke riwayat booking milik pelanggan
        return redirect()->route('bookinghistory.index')
            ->with('success', 'Reservasi berhasil dibuat! Silakan lakukan pembayaran.');
    }

    public function index()
    {
<<<<<<< HEAD
        // ✔️ DIPERBAIKI: Mengubah roomVariant menjadi room agar tidak error RelationNotFoundException
        $reservations = Reservation::with(['user', 'room'])->latest()->get();

=======
        $reservations = Reservation::with(['user', 'roomVariant'])->get();
>>>>>>> 09e1eec032c5730b60808b865c8bb66b85864c86
        return view('admin.reservasi', compact('reservations'));
    }
}