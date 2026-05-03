@extends('layouts.app')

@section('title', 'Pembatalan')

@section('content')

<div class="layout">

    @include('components.sidebar')

    <!-- MAIN CONTENT -->
    <div class="main p-4">

        <h4 class="mb-4 fw-bold">Pembatalan</h4>

        <!-- FILTER -->
        <div class="mb-3">
            <div class="section-title d-inline-block">Filter Status</div>

            <select class="form-select form-select-sm d-inline-block w-auto ms-2">
                <option>Semua</option>
                <option>Menunggu</option>
                <option>Disetujui</option>
                <option>Ditolak</option>
            </select>
        </div>

        <!-- TABLE PEMBATALAN -->
        <div class="card mb-4 shadow-sm" style="border-radius: 10px;">
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover text-center align-middle mb-0">

                        <thead class="text-muted" style="font-size:13px;">
                            <tr>
                                <th>Nama</th>
                                <th>Tipe Kamar</th>
                                <th>Check-In</th>
                                <th>Check-Out</th>
                                <th>Alasan Pembatalan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @if($data->isEmpty())

                                <tr>
                                    <td colspan="6" class="py-5 text-muted">
                                        <i class="bi bi-x-circle d-block mb-2" style="font-size:2rem;"></i>
                                        Belum ada pengajuan pembatalan
                                    </td>
                                </tr>

                            @else

                                @foreach($data as $item)

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

                                    <td>
                                        {{ $item->alasan_batal ?? '-' }}
                                    </td>

                                    <td>

                                        <div class="d-flex justify-content-center gap-2">

                                            <!-- ACC -->
                                            <form action="/admin/pembatalan/acc/{{ $item->id }}" method="POST">
                                                @csrf
                                                <button class="btn btn-sm btn-dark">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    ACC
                                                </button>
                                            </form>

                                            <!-- TOLAK -->
                                            <form action="/admin/pembatalan/tolak/{{ $item->id }}" method="POST">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-x-circle me-1"></i>
                                                    Tolak
                                                </button>
                                            </form>

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