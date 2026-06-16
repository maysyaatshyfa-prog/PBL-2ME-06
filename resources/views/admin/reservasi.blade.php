@extends('layouts.app')

@section('title', 'Reservasi')

@section('content')

<div class="layout">

    @include('components.sidebar')

    <div class="main p-4">

        <h4 class="mb-4 fw-bold">Reservasi</h4>

        <div class="mb-3">
            <div class="section-title d-inline-block">Filter Status</div>
            <select class="form-select form-select-sm d-inline-block w-auto ms-2">
                <option>Semua</option>
                <option>Menunggu</option>
                <option>Selesai</option>
            </select>
        </div>

        <div class="card mb-4 shadow-sm" style="border-radius: 10px;">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle mb-0">
                        <thead class="text-muted" style="font-size: 13px;">
                            <tr>
                                <th>Nama Tamu</th>
                                <th>Tipe Kamar</th>
                                <th>Nomor Kamar</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($reservations->isEmpty())
                            <tr>
                                <td colspan="4" class="py-5 text-muted">
                                    <i class="bi bi-inbox d-block mb-2" style="font-size: 2rem;"></i>
                                    Belum ada data reservasi
                                </td>
                            </tr>
                            @else
                            @foreach($reservations as $res)
                            <tr>
                                <td class="fw-semibold">{{ $res->user->name ?? '-' }}</td>

                                <td>{{ $res->roomNumber->variant->name ?? '-' }}</td>

                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $res->roomNumber->room_number ?? 'Belum Diatur' }}
                                    </span>
                                </td>

                                <td>
                                    @if($res->status == 'Menunggu')
                                    <span class="badge bg-warning text-dark px-3">Menunggu</span>
                                    @else
                                    <span class="badge bg-success px-3">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection