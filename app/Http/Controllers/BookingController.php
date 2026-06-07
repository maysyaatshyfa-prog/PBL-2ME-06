<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Menampilkan riwayat reservasi pelanggan
     */
    public function index()
    {
        $userId = Auth::id();
=======
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
>>>>>>> 09e1eec032c5730b60808b865c8bb66b85864c86

        $bookings = Reservation::with('room')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('bookinghistory', compact('bookings'));
    }

    /**
     * Menampilkan detail reservasi
     */
    public function show($id)
    {
        // Mencari data reservasi berdasarkan ID dan memastikan milik user yang login
        $booking = Reservation::with('room')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('booking_detail', compact('booking'));
    }

    /**
     * Membatalkan reservasi
     */
    public function cancel($id)
    {
        $booking = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Mengubah status menjadi Batal
        $booking->update(['status' => 'Batal']);

        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan.');
    }

    /**
     * Menampilkan form pendaftaran/pembuatan booking baru
     */
    public function create($id)
    {
        return view('booking.create', compact('id'));
    }

<<<<<<< HEAD
    /**
     * Menampilkan halaman konfirmasi booking
     */
    public function confirm(Request $request)
    {
        // Pastikan nama view ini sesuai dengan folder kamu
        return view('booking.confirm', compact('request'));
    }

    /**
     * Menampilkan halaman proses pembayaran
     */
=======
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


>>>>>>> 09e1eec032c5730b60808b865c8bb66b85864c86
    public function payment()
    {
        return view('booking.payment');
    }

    /**
     * Menampilkan halaman sukses setelah booking berhasil
     */
    public function success()
    {
        $bookingCode = 'BOOK-' . date('YmdHis');
        return view('success', compact('bookingCode'));
    }
    
    /**
     * Menyimpan data pembayaran (Opsional, pastikan sesuai kebutuhanmu)
     */
    public function storePayment(Request $request, $id)
    {
        // Logika simpan pembayaran di sini
    }
}