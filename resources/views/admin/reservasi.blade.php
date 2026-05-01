<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles/style_resika.css">
    <link rel="stylesheet" href="styles/style_maysya.css">
</head>

<body class="dashboard-page">

    <div class="layout">

        <!-- SIDEBAR -->
        <div class="sidebar">
            <h4 class="text-center py-4 text-white">Dashboard</h4>
        </div>

        <!-- CONTENT -->
        <div class="main-content p-4 w-100">

            <h4 class="mb-3 fw-bold">Reservasi</h4>

            <!-- FILTER -->
            <div class="mb-3">
                <label class="fw-semibold">Filter Status</label>
                <select class="form-select form-select-sm d-inline-block w-auto ms-2">
                    <option>Semua</option>
                    <option>Menunggu</option>
                    <option>Selesai</option>
                </select>
            </div>

            <!-- TABLE -->
            <div class="card p-3 shadow-sm" style="border-radius: 10px;">

                <table class="table table-hover text-center align-middle mb-0">

                    <thead style="font-size: 13px;">
                        <tr>
                            <th>Nama</th>
                            <th>Tipe Kamar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if($reservations->isEmpty())
                        <tr>
                            <td colspan="5" class="py-5 text-muted">
                                Belum ada reservasi
                            </td>
                        </tr>
                        @else
                        @foreach($reservations as $res)
                        <tr>
                            <td>{{ $res->user->name ?? '-' }}</td>
                            <td>{{ $res->room->type ?? '-' }}</td>
                            <td>{{ $res->room->room_number ?? '-' }}</td>

                            <!-- STATUS -->
                            <td>
                                @if($res->status == 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                                @else
                                <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>

                            <!-- AKSI -->
                            <td>
                                <button class="btn btn-sm btn-outline-dark">
                                    Assign Kamar
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>

                </table>

            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>