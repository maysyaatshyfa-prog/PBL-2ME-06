<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\RoomVariant;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function dashboard(Request $request)
    {
        $startDateInput = $request->get('start_date', Carbon::now()->startOfWeek()->format('Y-m-d'));
        $endDateInput = $request->get('end_date', Carbon::now()->endOfWeek()->format('Y-m-d'));

        $totalKamar = Room::count();
        $kamarTersedia = Room::where('status', 'tersedia')->count();

        $menungguPembayaran = Reservation::where('status', 'Menunggu Pembayaran')
            ->whereBetween('created_at', [$startDateInput, $endDateInput])->count();

        $totalPendapatan = Reservation::where('status', 'Lunas')
            ->whereBetween('created_at', [$startDateInput, $endDateInput])->sum('total_harga');

        $reservations = Reservation::with(['user', 'room'])->latest()->take(5)->get();

        $start = Carbon::parse($startDateInput);
        $end = Carbon::parse($endDateInput);
        
        $labels = []; $reservasiChart = []; $pendapatanChart = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $labels[] = $date->locale('id')->translatedFormat('D');
            $reservasiChart[] = Reservation::whereDate('created_at', $date)->count();
            $pendapatanChart[] = Reservation::where('status', 'Lunas')->whereDate('created_at', $date)->sum('total_harga');
        }

        return view('admin.dashboard', compact('totalKamar', 'kamarTersedia', 'menungguPembayaran', 'totalPendapatan', 'reservations', 'labels', 'reservasiChart', 'pendapatanChart'));
    }

    /*
    |--------------------------------------------------------------------------
    | KELOLA KAMAR
    |--------------------------------------------------------------------------
    */
    public function kelolaKamar()
{
    $rooms = RoomVariant::with([
            'room',
            'roomNumbers'
        ])
        ->withCount('roomNumbers')
        ->latest()
        ->paginate(10);

    return view('admin.kelola_kamar', compact('rooms'));
}


    /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN
    |--------------------------------------------------------------------------
    */
    public function pembayaran()
    {
        $payments = Reservation::with(['user', 'room'])
            ->where('status', 'Menunggu Pembayaran')
            ->latest()
            ->paginate(10);

        return view('admin.pembayaranadmin', compact('payments'));
    }

    public function accPembayaran($id)
    {
        $payment = Reservation::findOrFail($id);
        $payment->update(['status' => 'Lunas']);
        return back()->with('success', 'Pembayaran berhasil di ACC');
    }

    /*
    |--------------------------------------------------------------------------
    | PEMBATALAN
    |--------------------------------------------------------------------------
    */
    public function pembatalan()
    {
        $data = Reservation::with(['user', 'room'])
            ->where('status', 'Pengajuan Pembatalan')
            ->latest()
            ->paginate(10);

        return view('admin.pembatalanadmin', compact('data'));
    }

    public function accPembatalan($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => 'Dibatalkan']);
        return back()->with('success', 'Pembatalan berhasil disetujui');
    }

    public function tolakPembatalan($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => 'Lunas']);
        return back()->with('success', 'Pengajuan pembatalan ditolak');
    }

    /*
    |--------------------------------------------------------------------------
    | RESERVASI ADMIN
    |--------------------------------------------------------------------------
    */
    public function reservasiIndex(Request $request)
    {
        $statusFilter = $request->get('status');
        $query = Reservation::with(['user', 'room'])->latest();

        if ($statusFilter && $statusFilter !== 'Semua') {
            $statusMap = ['Menunggu' => 'Menunggu Pembayaran', 'Selesai' => 'Lunas'];
            $query->where('status', $statusMap[$statusFilter] ?? $statusFilter);
        }

        $reservations = $query->paginate(10);
        return view('admin.reservasi', compact('reservations', 'statusFilter'));
    }

    public function updateReservasiStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Lunas,Dibatalkan'
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status data reservasi berhasil diperbarui!');
    }

   public function daftarKamar($id)
{
    $variant = RoomVariant::with('roomNumbers')
                ->findOrFail($id);

    return view(
        'admin.daftar_kamar',
        compact('variant')
    );
}
}