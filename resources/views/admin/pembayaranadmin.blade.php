@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')

<div class="layout">

    @include('components.sidebar')

    <!-- MAIN CONTENT -->
    <div class="main p-4">

        <h4 class="mb-4 fw-bold">Pembayaran</h4>

        <!-- FILTER -->
        <div class="mb-3">
            <div class="section-title d-inline-block">Filter Status</div>

            <select class="form-select form-select-sm d-inline-block w-auto ms-2">
                <option>Semua</option>
                <option>Menunggu Verifikasi</option>
                <option>Lunas</option>
            </select>
        </div>

        <!-- TABLE PEMBAYARAN -->
        <div class="card mb-4 shadow-sm" style="border-radius: 10px;">
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover text-center align-middle mb-0">

                        <thead class="text-muted" style="font-size:13px;">
                            <tr>
                                <th>Nama Tamu</th>
                                <th>Tipe Kamar</th>
                                <th>Check-In</th>
                                <th>Check-Out</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @if($payments->isEmpty())

                                <tr>
                                    <td colspan="6" class="py-5 text-muted">
                                        <i class="bi bi-credit-card d-block mb-2" style="font-size:2rem;"></i>
                                        Belum ada data pembayaran
                                    </td>
                                </tr>

                            @else

                                @foreach($payments as $item)

                                <tr>
                                    <td class="fw-semibold">
                                        {{ $item->user->name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->room->type ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->check_in ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->check_out ?? '-' }}
                                    </td>

                                    <!-- STATUS -->
                                    <td>
                                        @if($item->status == 'Lunas')
                                            <span class="badge bg-success px-3">
                                                Lunas
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark px-3">
                                                Menunggu
                                            </span>
                                        @endif
                                    </td>

                                    <!-- AKSI -->
                                    <td>

                                        <div class="d-flex justify-content-center gap-2">

                                            <form action="/admin/pembayaran/acc/{{ $item->id }}" method="POST">
                                                @csrf

                                                <button class="btn btn-sm btn-dark">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    ACC
                                                </button>
                                            </form>

                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                        </div>

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