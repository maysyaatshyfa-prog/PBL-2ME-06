<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Menampilkan riwayat reservasi pelanggan
     */
    public function index()
    {
        $userId = Auth::id();

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
    public function payment()
    {
        return view('booking.payment');
    }

    /**
     * Menampilkan halaman sukses setelah booking berhasil
     */
    public function success()
    {
        return view('booking.success');
    }
    
    /**
     * Menyimpan data pembayaran (Opsional, pastikan sesuai kebutuhanmu)
     */
    public function storePayment(Request $request, $id)
    {
        // Logika simpan pembayaran di sini
    }
}