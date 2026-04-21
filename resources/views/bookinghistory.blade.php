<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookinghistory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('styles/style_resika.css') }}">

</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar d-flex justify-content-between align-items-center flex-wrap">
        <div class="logo mb-2 mb-md-0">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>

        <div class="d-flex flex-wrap justify-content-center">
            <a href="#">Beranda</a>
            <a href="#">Kamar</a>
            <a href="{{ route('bookinghistory.index') }}" class="active-tab">Reservasi Saya</a>
            <a href="#">Masuk</a>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="container-fluid px-3 px-md-5">

        <h2 class="title">HISTORY RESERVASI</h2>

        <div class="card-box">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kamar</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($bookings as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('img/kamar.jpg') }}" class="room-img me-2">
                                    {{ $item->room-name ?? 'kamar' }}
                                </div>
                            </td>

                            <td>{{ \Carbon\Carbon::parse($item->checkin)->translatedFormat('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->checkout)->translatedFormat('d F Y') }}</td>

                            <td>
                                <span class="badge-status
    @if($item->status == 'Selesai') status-selesai
    @elseif($item->status == 'Proses') status-proses
    @elseif($item->status == 'Batal') status-batal
    @endif
">
                                    {{ $item->status }}
                                </span>
                            </td>

                            <td>
                                <button class="btn-detail">Detail</button>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada data reservasi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

</body>

</html>
