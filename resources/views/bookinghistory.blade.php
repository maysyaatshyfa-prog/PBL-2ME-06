@extends('layouts.app')

@section('title', 'History Booking')

@section('content')

{{-- Navbar --}}
@include('components.navbar')

<div class="container-fluid px-3 px-md-5">

    <h2 class="title">HISTORY RESERVASI</h2>

    <div class="card-box">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tipe Kamar</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Status Reservasi</th>
                        <th>Status Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($bookings as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('img/kamar.jpg') }}" class="room-img me-2">
                                {{ $item->room->name ?? 'Kamar' }}
                            </div>
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->checkin)->translatedFormat('d F Y') }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->checkout)->translatedFormat('d F Y') }}
                        </td>

                        {{-- STATUS RESERVASI --}}
                        <td>
                            <span class="badge-status
                                @if($item->status == 'Selesai')
                                    status-selesai
                                @elseif($item->status == 'Proses')
                                    status-proses
                                @elseif($item->status == 'Batal')
                                    status-batal
                                @else
                                    status-proses
                                @endif
                            ">
                                {{ $item->status }}
                            </span>
                        </td>

                        {{-- STATUS PEMBAYARAN --}}
                        <td>
                            <span class="badge-status
                                @if(($item->payment_status ?? 'Belum Bayar') == 'Lunas')
                                    status-selesai
                                @elseif(($item->payment_status ?? 'Belum Bayar') == 'Menunggu')
                                    status-proses
                                @else
                                    status-batal
                                @endif
                            ">
                                {{ $item->payment_status ?? 'Belum Bayar' }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td>
                            <div class="d-flex gap-2">

                                <a href="/booking/{{ $item->id }}" class="btn btn-primary btn-sm">
                                    Detail
                                </a>

                                {{-- tombol bayar hanya jika belum bayar --}}
                                @if(($item->payment_status ?? 'Belum Bayar') == 'Belum Bayar')
                                <a href="/payment/{{ $item->id }}" class="btn btn-success btn-sm">
                                    Bayar
                                </a>
                                @endif

                                {{-- tombol batal hanya jika masih proses --}}
                                @if($item->status == 'Proses')
                                <form action="/booking/cancel/{{ $item->id }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">
                                        Batalkan
                                    </button>
                                </form>
                                @endif

                            </div>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada data reservasi
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection