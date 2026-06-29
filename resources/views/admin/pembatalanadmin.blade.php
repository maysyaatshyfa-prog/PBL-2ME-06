@extends('layouts.app')

@section('title', 'Pembatalan')

@section('content')
<div class="layout">
    @include('components.sidebar')

    <div class="main p-4">
        <h4 class="mb-4 fw-bold">Pembatalan</h4>
        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="mb-0">Daftar Pengajuan Pembatalan</h5>

            <form action="{{ route('admin.pembatalan') }}" method="GET" class="d-flex gap-2">

                <input type="text" name="search" class="form-control" placeholder="Cari nama tamu / kamar"
                    value="{{ request('search') }}">

                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">

                <button type="submit" class="btn btn-primary">
                    Cari
                </button>

                <a href="{{ route('admin.pembatalan') }}" class="btn btn-secondary">
                    Reset
                </a>

            </form>

        </div>
        <div class="card mb-4 shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle mb-0">
                        <thead class="text-muted" style="font-size:13px;">
                            <tr>
                                <th>Kode Reservasi</th>
                                <th>Nama Tamu</th>
                                <th>Alasan Pembatalan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                            <tr>

                                <td>
                                    RSV-{{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}
                                </td>

                                <td>
                                    {{ $item->user->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $item->cancellation->reason ?? '-' }}
                                </td>

                                <td>
                                    {{ $item->cancellation->created_at->format('d M Y') ?? '-' }}
                                </td>

                                <td>
                                    <span class="badge bg-warning text-dark">
                                        Menunggu
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-3">

                                        <form action="{{ route('admin.pembatalan.acc', $item->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-success btn-sm rounded-pill px-3">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Setujui
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.pembatalan.tolak', $item->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                Tolak
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-5 text-muted">
                                    <i class="bi bi-x-circle d-block mb-2" style="font-size:2rem;"></i>
                                    Belum ada pengajuan pembatalan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@if(session('approved'))
<script>
    document.addEventListener('DOMContentLoaded', function () {

        Swal.fire({
            icon: 'success',
            title: 'Pembatalan Disetujui',
            text: '{{ session("approved") }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#198754'
        });

    });
</script>
@endif

@if(session('rejected'))
<script>
    document.addEventListener('DOMContentLoaded', function () {

        Swal.fire({
            icon: 'warning',
            title: 'Pembatalan Ditolak',
            text: '{{ session("rejected") }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc3545'
        });

    });
</script>
@endif
@endsection