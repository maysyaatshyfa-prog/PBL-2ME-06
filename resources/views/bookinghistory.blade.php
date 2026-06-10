@extends('layouts.app')

@section('title', 'History Booking')

@section('content')

@include('components.navbar')

<div class="container-fluid px-3 px-md-5">

    <h2 class="title my-4">HISTORY RESERVASI</h2>

    <div class="card-box shadow-sm rounded-4 p-4 bg-white">

        <div class="table-responsive">

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

                        <td class="text-start">
                            <div class="d-flex align-items-center py-2">

                                <img src="{{ ($item->room && $item->room->firstVariant && $item->room->firstVariant->image)
        ? asset('images/' . $item->room->firstVariant->image)
        : asset('img/kamar.jpg') }}"
                                    class="rounded-3 shadow-sm me-3"
                                    style="width:110px;height:75px;object-fit:cover;">

                                <span class="fw-semibold">
                                    {{ $item->room->title ?? $item->room->name ?? 'Kamar Tidak Ditemukan' }}
                                </span>

                            </div>
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->check_in)->translatedFormat('d M Y') }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->check_out)->translatedFormat('d M Y') }}
                        </td>

                        {{-- STATUS RESERVASI --}}
                        <td>
                            @if($item->status == 'Selesai')
                                <span class="badge bg-success px-3 py-2 rounded-pill">
                                    Selesai
                                </span>

                            @elseif($item->status == 'Batal')
                                <span class="badge bg-danger px-3 py-2 rounded-pill">
                                    Batal
                                </span>

                            @else
                                <span class="badge bg-primary px-3 py-2 rounded-pill">
                                    Dalam Proses
                                </span>
                            @endif
                        </td>

                        {{-- STATUS PEMBAYARAN --}}
                        <td>
                            @if($item->status_pembayaran == 'Lunas')
                                <span class="badge bg-success px-3 py-2 rounded-pill">
                                    Lunas
                                </span>
                            @else
                                <span class="badge bg-danger px-3 py-2 rounded-pill">
                                    Belum Bayar
                                </span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td>

                            <div class="d-flex justify-content-center gap-2">

                                <a href="/booking/detail/{{ $item->id }}"
                                    class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                    Detail
                                </a>

                                @if($item->status_pembayaran != 'Lunas')
                                    <a href="/payment/{{ $item->id }}"
                                        class="btn btn-success btn-sm rounded-pill px-3">
                                        Bayar
                                    </a>
                                @endif

                                @if($item->status != 'Selesai' && $item->status != 'Batal')
                                    <form action="/booking/cancel/{{ $item->id }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin membatalkan reservasi ini?')">

                                        @csrf

                                        <button class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            Batalkan
                                        </button>

                                    </form>
                                @endif

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            Belum ada data reservasi yang tersedia.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection