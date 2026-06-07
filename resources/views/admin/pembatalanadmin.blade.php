@extends('layouts.app')

@section('title', 'Pembatalan')

@section('content')
<div class="layout">
    @include('components.sidebar')

    <div class="main p-4">
        <h4 class="mb-4 fw-bold">Pembatalan</h4>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

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
                            @forelse($data as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item->user->name ?? '-' }}</td>
                                <td>{{ $item->room->type ?? '-' }}</td>
                                <td>{{ $item->check_in ?? '-' }}</td>
                                <td>{{ $item->check_out ?? '-' }}</td>
                                <td>{{ $item->alasan_batal ?? '-' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('admin.accPembatalan', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menyetujui pembatalan ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-dark"><i class="bi bi-check-circle me-1"></i> ACC</button>
                                        </form>

                                        <form action="{{ route('admin.tolakPembatalan', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak pembatalan ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle me-1"></i> Tolak</button>
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
@endsection