@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="layout">
    @include('components.sidebar')

    <div class="main p-4">
        <h4 class="mb-4 fw-bold">Pembayaran</h4>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="mb-3">
            <span class="text-muted">Filter Status:</span>
            <select class="form-select form-select-sm d-inline-block w-auto ms-2">
                <option>Semua</option>
                <option>Menunggu Verifikasi</option>
                <option>Lunas</option>
            </select>
        </div>

        <div class="card mb-4 shadow-sm border-0" style="border-radius: 12px;">
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
                            @forelse($payments as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item->user->name ?? '-' }}</td>
                                <td>{{ $item->room->type ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->check_in)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->check_out)->format('d M Y') }}</td>
                                <td>
                                    @if($item->status == 'Lunas')
                                        <span class="badge bg-success px-3 rounded-pill">Lunas</span>
                                    @else
                                        <span class="badge bg-warning text-dark px-3 rounded-pill">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        @if($item->status !== 'Lunas')
                                            <form action="{{ route('admin.accPembayaran', $item->id) }}" method="POST" 
                                                  onsubmit="return confirm('Yakin ingin ACC pembayaran ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-dark">
                                                    <i class="bi bi-check-circle me-1"></i> ACC
                                                </button>
                                            </form>
                                        @endif
                                        <button class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-5 text-muted">Belum ada data pembayaran</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection