@extends('layouts.app')

@section('title', 'History Booking')

@section('content')

{{-- Navbar --}}
@include('components.navbar')

<!-- CONTENT -->
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
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($bookings as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <div class="d-flex align-items-center">

                                <img src="{{ asset('img/kamar.jpg') }}"
                                    class="room-img me-2">

                                {{ $item->room->name ?? 'Kamar' }}

                            </div>
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->checkin)->translatedFormat('d F Y') }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->checkout)->translatedFormat('d F Y') }}
                        </td>

                        <td>

                            <span class="badge-status

                                @if($item->status == 'Selesai')
                                    status-selesai
                                @elseif($item->status == 'Proses')
                                    status-proses
                                @elseif($item->status == 'Batal')
                                    status-batal
                                @endif
                            ">

                                {{ $item->status }}

                            </span>

                        </td>

                        <td>
                            <button class="btn-detail">
                                Detail
                            </button>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
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