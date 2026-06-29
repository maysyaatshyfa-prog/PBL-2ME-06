@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="layout">
    @include('components.sidebar')

    <div class="main p-4">
        <h4 class="mb-4 fw-bold">Pembayaran</h4>
        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="mb-0">Daftar Pembayaran</h5>

            <form action="{{ route('admin.pembayaran') }}" method="GET" class="d-flex gap-2">

                <input type="text" name="search" class="form-control" placeholder="Cari nama tamu / kode reservasi"
                    value="{{ request('search') }}">

                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">

                <button type="submit" class="btn btn-primary">
                    Cari
                </button>

                <a href="{{ route('admin.pembayaran') }}" class="btn btn-secondary">
                    Reset
                </a>

            </form>

        </div>
        <div class="card mb-4 shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle mb-0">
                        <thead class="text-muted" style="font-size:13px;">
                            <tr>
                                <th>Kode Pembayaran</th>
                                <th>Kode Reservasi</th>
                                <th>Nama Tamu</th>
                                <th>Total Pembayaran</th>
                                <th>Metode Pembayaran</th>
                                <th>Status Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $item)
                            <tr>

                                <td>
                                    PAY-{{ $item->created_at->format('Ymd') }}-{{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}
                                </td>

                                <td>
                                    RSV-{{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}
                                </td>

                                <td>
                                    {{ $item->customer_name ?? $item->guest_name ?? '-' }}
                                </td>

                                <td class="fw-semibold text-success">
                                    Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                </td>

                                <td>
                                    Midtrans
                                </td>

                                <td>
                                    @if($item->status_pembayaran == 'Lunas')
                                    <span class="badge bg-success px-3 rounded-pill">
                                        Lunas
                                    </span>
                                    @else
                                    <span class="badge bg-warning text-dark px-3 rounded-pill">
                                        Belum Bayar
                                    </span>
                                    @endif
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-5 text-muted">
                                    Belum ada data pembayaran
                                </td>
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