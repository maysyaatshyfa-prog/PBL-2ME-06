@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">


<div class="layout">

    @include('components.sidebar')

    <div class="main">

        <h4 class="mb-4">Beranda</h4>

        <div class="section-title">Statistik Hotel</div>

        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="card-click p-4 d-flex flex-column align-items-center justify-content-center" style="min-height: 155px; border-radius: 12px;">
                    <h2 class="stat-number text-dark m-0">
                        {{ $totalKamar }}
                    </h2>
                    <div class="stat-card-title text-muted text-uppercase mt-2">
                        Total Kamar
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-click p-4 d-flex flex-column align-items-center justify-content-center" style="min-height: 155px; border-radius: 12px;">
                    <h2 class="stat-number text-success m-0">
                        {{ $kamarTersedia }}
                    </h2>
                    <div class="stat-card-title text-muted text-uppercase mt-2">
                        Kamar Tersedia
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-click p-4 d-flex flex-column align-items-center justify-content-center" style="min-height: 155px; border-radius: 12px;">
                    <h2 class="stat-number text-warning m-0">
                        {{ $menungguPembayaran }}
                    </h2>
                    <div class="stat-card-title text-muted text-uppercase mt-2">
                        Menunggu Pembayaran
                    </div>
                </div>
            </div>

        </div>

        <div class="card mb-4 shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
                <form action="" method="GET" class="row g-3 align-items-center">
                    <div class="col-auto">
                        <span class="fw-bold text-secondary" style="font-size: 14px;">Periode Grafik:</span>
                    </div>
                    <div class="col-auto">
                        <input type="date" name="start_date" class="form-control form-control-sm" 
                               value="{{ request('start_date', now()->subDays(30)->format('Y-m-d')) }}">
                    </div>
                    <div class="col-auto text-muted">s/d</div>
                    <div class="col-auto">
                        <input type="date" name="end_date" class="form-control form-control-sm" 
                               value="{{ request('end_date', now()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-sm btn-dark px-3">
                            Filter Data
                        </button>
                        @if(request('start_date') || request('end_date'))
                            <a href="{{ request()->url() }}" class="btn btn-sm btn-outline-secondary ms-1">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-4 mb-4">

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="section-title mb-3">
                            Grafik Reservasi
                        </div>
                        <canvas id="reservasiChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="section-title mb-3">
                            Grafik Pendapatan
                        </div>
                        <canvas id="pendapatanChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="section-title mb-3">
                    Riwayat Booking
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tamu</th>
                                <th>Tipe Kamar</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations as $item)
                                <tr>
                                    <td>
                                        {{ $item->user->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $item->room->title ?? $item->room->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $item->check_in }}
                                    </td>
                                    <td>
                                        {{ $item->check_out }}
                                    </td>
                                    <td>
                                        @if($item->status == 'Lunas')
                                            <span class="badge bg-success">
                                                {{ $item->status }}
                                            </span>
                                        @elseif($item->status == 'Menunggu Pembayaran')
                                            <span class="badge bg-warning text-dark">
                                                {{ $item->status }}
                                            </span>
                                        @elseif($item->status == 'Dibatalkan')
                                            <span class="badge bg-danger">
                                                {{ $item->status }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ $item->status }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Belum ada data booking
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="section-title mb-2">
                    Tindakan Cepat
                </div>
                <a href="#" class="btn btn-dark">
                    + Tambah Kamar
                </a>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($labels);
    const reservasiData = @json($reservasiChart);
    const pendapatanData = @json($pendapatanChart);

    // Render Grafik Reservasi (Line Chart)
    new Chart(document.getElementById('reservasiChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Reservasi',
                data: reservasiData,
                borderColor: '#1f2a44',
                backgroundColor: 'rgba(197,161,90,0.3)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Render Grafik Pendapatan (Bar Chart)
    new Chart(document.getElementById('pendapatanChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: pendapatanData,
                backgroundColor: '#c5a15a'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection