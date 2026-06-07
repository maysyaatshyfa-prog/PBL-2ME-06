@extends('layouts.app')

@section('title', 'History Booking')

@section('content')

{{-- Navbar --}}
@include('components.navbar')

<div class="container-fluid px-3 px-md-5">

    <h2 class="title my-4">HISTORY RESERVASI</h2>

    {{-- Card Container --}}
    <div class="card-box shadow-sm rounded-4 p-4 bg-white">

        <div class="table-responsive">
            {{-- Menambahkan table-hover agar baris merespons kursor --}}
            <table class="table table-hover align-middle text-center">

                <thead>
                    <tr class="table-dark">
                        <th class="py-3">No</th>
                        <th class="py-3">Tipe Kamar</th>
                        <th class="py-3">Check-in</th>
                        <th class="py-3">Check-out</th>
                        <th class="py-3">Status Reservasi</th>
                        <th class="py-3">Status Pembayaran</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($bookings as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        {{-- TIPE KAMAR + IMAGE --}}
                        <td class="text-start">
                            <div class="d-flex align-items-center py-2">
                                {{-- Pastikan menggunakan asset() dengan benar --}}
                                <img src="{{ $item->room && $item->room->image ? asset('storage/' . $item->room->image) : asset('img/kamar.jpg') }}" 
                                     class="rounded-3 shadow-sm me-3" 
                                     style="width: 90px; height: 60px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='https://placehold.co/90x60?text=No+Image';">
                                
                                <span class="fw-semibold">{{ $item->room->title ?? ($item->room->name ?? 'Kamar Tidak Ditemukan') }}</span>
                            </div>
                        </td>

                        {{-- TANGGAL --}}
                        <td>{{ \Carbon\Carbon::parse($item->checkin)->translatedFormat('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->checkout)->translatedFormat('d M Y') }}</td>

                        {{-- STATUS RESERVASI --}}
                        <td>
                            <span class="badge {{ $item->status == 'Selesai' ? 'bg-success' : 'bg-primary' }} px-3 py-2 rounded-pill">
                                {{ $item->status }}
                            </span>
                        </td>

                        {{-- STATUS PEMBAYARAN --}}
                        <td>
                            <span class="badge {{ ($item->payment_status ?? 'Belum Bayar') == 'Lunas' ? 'bg-success' : 'bg-danger' }} px-3 py-2 rounded-pill">
                                {{ $item->payment_status ?? 'Belum Bayar' }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="/booking/detail/{{ $item->id }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Detail</a>

                                @if(($item->payment_status ?? 'Belum Bayar') == 'Belum Bayar')
                                <a href="/payment/{{ $item->id }}" class="btn btn-success btn-sm rounded-pill px-3">Bayar</a>
                                @endif

                                @if($item->status == 'Proses' || $item->status == 'pending')
                                <form action="/booking/cancel/{{ $item->id }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan?')">
                                    @csrf
                                    <button class="btn btn-outline-danger btn-sm rounded-pill px-3">Batalkan</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Belum ada data reservasi yang tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection