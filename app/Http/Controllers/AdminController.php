<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomNumber;
use App\Models\RoomVariant;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard(Request $request)
    {
        $startDateInput = $request->get('start_date', Carbon::now()->startOfWeek()->format('Y-m-d'));
        $endDateInput = $request->get('end_date', Carbon::now()->endOfWeek()->format('Y-m-d'));

        $totalKamar = Room::count();
        $kamarTersedia = Room::where('status', 'tersedia')->count();

        $totalPembayaran = Reservation::where('status_pembayaran', 'Lunas')->count();

        $totalPendapatan = Reservation::where('status_pembayaran', 'Lunas')
            ->whereBetween('created_at', [$startDateInput, $endDateInput])
            ->sum('total_harga');

        $reservations = Reservation::with([
            'user',
            'roomVariant',
            'roomNumber'
        ])->latest()->take(5)->get();

        $start = Carbon::parse($startDateInput);
        $end = Carbon::parse($endDateInput);

        $labels = [];
        $reservasiChart = [];
        $pendapatanChart = [];

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $labels[] = $date->locale('id')->translatedFormat('D');

            $reservasiChart[] = Reservation::whereDate('created_at', $date)->count();

            $pendapatanChart[] = Reservation::where('status_pembayaran', 'Lunas')
                ->whereDate('created_at', $date)
                ->sum('total_harga');
        }

        return view('admin.dashboard', compact(
            'totalKamar',
            'kamarTersedia',
            'totalPembayaran',
            'totalPendapatan',
            'reservations',
            'labels',
            'reservasiChart',
            'pendapatanChart'
        ));
    }

    // Reservasi
    public function reservasiIndex(Request $request)
    {
        $query = Reservation::with([
            'user',
            'roomNumber.variant'
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('roomNumber.variant', function ($r) use ($search) {
                    $r->where('name', 'like', "%{$search}%");
                })
                ->orWhere('id', $search);
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('check_in', $request->tanggal);
        }

        $reservations = $query->latest()->paginate(10)->withQueryString();

        return view('admin.reservasi', compact('reservations'));
    }

    // Pembayaran
    public function pembayaran(Request $request)
    {
        $query = Reservation::with([
            'user',
            'roomNumber.variant'
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('roomNumber.variant', function ($r) use ($search) {
                    $r->where('name', 'like', "%{$search}%");
                })
                ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $payments = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pembayaranadmin', compact('payments'));
    }
    // Pembatalan
    public function pembatalan(Request $request)
    {
        $query = Reservation::with([
            'user',
            'cancellation',
            'roomNumber.variant'
        ])->whereHas('cancellation', function ($q) {
            $q->where('status', 'Menunggu');
        });

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('roomNumber.variant', function ($r) use ($search) {
                    $r->where('name', 'like', "%{$search}%");
                })
                ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $data = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pembatalanadmin', compact('data'));
    }

    public function accPembatalan($id)
    {
        $reservation = Reservation::with('cancellation')->findOrFail($id);

        $reservation->cancellation?->update([
            'status' => 'disetujui'
        ]);

        return back()->with(
            'approved',
            'Pengajuan pembatalan berhasil disetujui'
        );
    }

    public function tolakPembatalan($id)
    {
        $reservation = Reservation::with('cancellation')->findOrFail($id);

        $reservation->cancellation?->update([
            'status' => 'ditolak'
        ]);

        return back()->with(
            'rejected',
            'Pengajuan pembatalan berhasil ditolak'
        );
    }

    // Kelola Kamar
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

    public function daftarKamar($id)
    {
        $variant = RoomVariant::with('roomNumbers')->findOrFail($id);

        return view('admin.daftar_kamar', compact('variant'));
    }

    public function tambahKamar(Request $request)
    {
        $request->validate([
            'room_variant_id' => 'required',
            'jumlah' => 'required|integer|min:1'
        ]);

        $variant = RoomVariant::findOrFail($request->room_variant_id);

        $lastRoom = RoomNumber::where('room_variant_id', $variant->id)
            ->orderBy('room_number', 'desc')
            ->first();

        $nextNumber = $lastRoom
            ? $lastRoom->room_number + 1
            : 101;

        for ($i = 0; $i < $request->jumlah; $i++) {
            RoomNumber::create([
                'room_variant_id' => $variant->id,
                'room_number' => $nextNumber + $i,
                'floor' => substr($nextNumber + $i, 0, 1),
                'status' => 'tersedia'
            ]);
        }

        return back()->with(
            'success',
            $request->jumlah . ' kamar berhasil ditambahkan'
        );
    }
    // Edit Kamar
    public function edit($id)
    {
        $variant = RoomVariant::findOrFail($id);

        return view('admin.edit_kamar', compact('variant'));
    }

    public function update(Request $request, $id)
    {
        $variant = RoomVariant::findOrFail($id);

        $data = [
            'name'        => $request->name,
            'price'       => $request->price,
            'capacity'    => $request->capacity,
            'size'        => $request->size,
            'bed_type'    => $request->bed_type,
            'room_view'   => $request->room_view,
            'description' => $request->description,
            'facilities'  => $request->facilities,
        ];

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();

            $request->image->move(
                public_path('images'),
                $imageName
            );

            $data['image'] = $imageName;
        }

        $gallery = json_decode($variant->gallery, true) ?? [];

        if ($request->has('replace_gallery')) {
            foreach ($request->file('replace_gallery') as $index => $file) {
                if ($file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();

                    $file->move(
                        public_path('images'),
                        $fileName
                    );

                    $gallery[$index] = $fileName;
                }
            }
        }

        $data['gallery'] = json_encode($gallery);

        $variant->update($data);

        return redirect()
            ->route('admin.kelola-kamar')
            ->with('success', 'Data kamar berhasil diperbarui');
    }
    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required'
    ]);

    $reservation = Reservation::findOrFail($id);

    $reservation->update([
        'status' => $request->status
    ]);

    return back()->with('success', 'Status reservasi berhasil diperbarui.');
}
    
}