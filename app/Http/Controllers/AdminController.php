<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalKamar = Room::count();
        $kamarTersedia = Room::where('status', 'tersedia')->count();

        $reservations = Reservation::with('user', 'room')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalKamar',
            'kamarTersedia',
            'reservations'
        ));
    }

    public function kelolaKamar()
    {
       $rooms = Room::with('variant.type')->get();

        return view('admin.kelola_kamar', compact('rooms'));
    }


    // =========================
    // HALAMAN PEMBAYARAN
    // =========================
    public function pembayaran()
    {
        $payments = Reservation::with('user', 'room')
            ->latest()
            ->get();

        return view('admin.pembayaranadmin', compact('payments'));
    }

    // =========================
    // HALAMAN PEMBATALAN
    // =========================
    public function pembatalan()
    {
        $data = Reservation::with('user', 'room')
            ->latest()
            ->get();

        return view('admin.pembatalanadmin', compact('data'));
    }

    // =========================
    // ACC PEMBAYARAN
    // =========================
    public function accPembayaran($id)
    {
        $payment = Reservation::findOrFail($id);
        $payment->status = 'Lunas';
        $payment->save();

        return back()->with('success', 'Pembayaran berhasil di ACC');
    }

    // =========================
    // ACC PEMBATALAN
    // =========================
    public function accPembatalan($id)
    {
        $item = Reservation::findOrFail($id);

        $item->status = 'Dibatalkan';
        $item->save();

        return back()->with('success', 'Pembatalan disetujui');
    }

    // =========================
    // TOLAK PEMBATALAN
    // =========================
    public function tolakPembatalan($id)
    {
        $item = Reservation::findOrFail($id);

        $item->status = 'Aktif';
        $item->save();

        return back()->with('success', 'Pengajuan pembatalan ditolak');
    }
}