@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<div class="layout">

    @include('components.sidebar')

    <!-- MAIN -->
    <div class="main">

        <h4 class="mb-4">Beranda</h4>

        <!-- STATISTIK -->
        <div class="section-title">Statistik Hotel</div>

        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="card-click p-3">
                    <div class="title">Total Kamar</div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="card-click p-3">
                    <div class="title">Kamar Tersedia</div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="card-click p-3">
                    <div class="title">Menunggu Pembayaran</div>

                </div>
            </div>

        </div>

        <!-- GRAFIK -->
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

        <!-- TABLE -->
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

                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada data booking
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>
        </div>

        <!-- ACTION -->
        <div class="card">
            <div class="card-body">
                <div class="section-title mb-2">
                    Tindakan Cepat
                </div>

                <button class="btn btn-dark">
                    + Tambah Kamar
                </button>
            </div>
        </div>

    </div>
</div>

<!-- CHART -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    new Chart(document.getElementById('reservasiChart'), {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Reservasi',
                data: [5, 10, 8, 12, 7, 15, 9],
                borderColor: '#1f2a44',
                backgroundColor: 'rgba(197,161,90,0.3)',
                tension: 0.4
            }]
        }
    });

    new Chart(document.getElementById('pendapatanChart'), {
        type: 'bar',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Pendapatan',
                data: [500, 1000, 800, 1200, 700, 1500, 900],
                backgroundColor: '#c5a15a'
            }]
        }
    });
</script>

@endsection