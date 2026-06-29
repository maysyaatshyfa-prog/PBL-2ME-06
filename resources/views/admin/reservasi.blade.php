@extends('layouts.app')

@section('title', 'Reservasi')

@section('content')

<div class="layout">

    @include('components.sidebar')

    <div class="main p-4">

        <h4 class="mb-4 fw-bold">Reservasi</h4>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Daftar Reservasi</h5>

            <form action="{{ route('admin.reservasi.index') }}" method="GET" class="d-flex gap-2">

                <input type="text" name="search" class="form-control" placeholder="Cari nama, kamar, kode reservasi..."
                    value="{{ request('search') }}">

                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">

                <button type="submit" class="btn btn-primary">
                    Cari
                </button>

                <a href="{{ route('admin.reservasi.index') }}" class="btn btn-secondary">
                    Reset
                </a>

            </form>
        </div>

        <div class="card mb-4 shadow-sm" style="border-radius: 10px;">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle mb-0">

                        <thead class="text-muted" style="font-size: 13px;">
                            <tr>
                                <th>Kode Reservasi</th>
                                <th>Nama Tamu</th>
                                <th>Tipe Kamar</th>
                                <th>Nomor Kamar</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Bukti KTP</th>
                                <th>Status Reservasi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @if($reservations->isEmpty())

                            <tr>
                                <td colspan="8" class="py-5 text-muted text-center">
                                    <i class="bi bi-inbox d-block mb-2"></i>
                                    Belum ada data reservasi
                                </td>
                            </tr>

                            @else

                            @foreach($reservations as $res)
                            <tr>

                                {{-- KODE RESERVASI --}}
                                <td class="fw-semibold">
                                    {{ $res->booking_code ?? ('RSV-' . str_pad($res->id, 6, '0', STR_PAD_LEFT)) }}
                                </td>

                                {{-- NAMA TAMU --}}
                                <td>
                                    {{ $res->customer_name ?? $res->guest_name ?? '-' }}
                                </td>

                                {{-- TIPE KAMAR --}}
                                <td>
                                    {{ $res->roomNumber->variant->name ?? $res->roomVariant->name ?? '-' }}
                                </td>

                                {{-- NOMOR KAMAR --}}
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $res->roomNumber->room_number ?? 'Belum Diatur' }}
                                    </span>
                                </td>

                                {{-- CHECK IN --}}
                                <td>
                                    {{ $res->check_in ? \Carbon\Carbon::parse($res->check_in)->translatedFormat('d M Y') : '-' }}
                                </td>

                                {{-- CHECK OUT --}}
                                <td>
                                    {{ $res->check_out ? \Carbon\Carbon::parse($res->check_out)->translatedFormat('d M Y') : '-' }}
                                </td>

                                {{-- BUKTI KTP --}}
                                <td>
                                    @if($res->ktp)
                                    <a href="{{ asset('storage/ktp/'.$res->ktp) }}" target="_blank"
                                        class="btn btn-sm btn-success">
                                        Lihat KTP
                                    </a>
                                    @else
                                    <span class="text-muted">Belum Upload</span>
                                    @endif
                                </td>

                                <td class="text-center">

                                    @if($res->status == 'Selesai')

                                    <span class="badge bg-success px-3 py-2 fs-6">
                                        <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                    </span>

                                    @else

                                    <form action="{{ route('admin.reservasi.status', $res->id) }}" method="POST"
                                        class="status-form">
                                        @csrf

                                        <select name="status" class="form-select form-select-sm status-select
    @if($res->status == 'Menunggu Check-in') status-wait
    @elseif($res->status == 'Sedang Menginap') status-stay
    @elseif($res->status == 'Batal') status-cancel
    @endif">
                                            <option value="Menunggu Check-in"
                                                {{ $res->status=='Menunggu Check-in'?'selected':'' }}>
                                                Menunggu Check-in
                                            </option>

                                            <option value="Sedang Menginap"
                                                {{ $res->status=='Sedang Menginap'?'selected':'' }}>
                                                Sedang Menginap
                                            </option>

                                            <option value="Selesai" {{ $res->status=='Selesai'?'selected':'' }}>
                                                Selesai
                                            </option>

                                        </select>

                                        <button class="btn btn-success btn-sm">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>

                                    @endif

                                </td>

                            </tr>
                            @endforeach

                            @endif

                        </tbody>

                    </table>

                    <div class="mt-3">
                        {{ $reservations->links() }}
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

@endsection
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 1800,
            showConfirmButton: false
        });
    });
</script>
@endif