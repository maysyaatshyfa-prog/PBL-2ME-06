@extends('layouts.app')

@section('title', 'Kelola Kamar')

@section('content')

<div class="layout d-flex">

    {{-- SIDEBAR --}}
    @include('components.sidebar')

    {{-- MAIN CONTENT --}}
    <div class="main flex-grow-1 p-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Kelola Kamar</h4>
        </div>

        {{-- FILTER + SEARCH --}}
        <form method="GET" action="{{ route('rooms.index') }}" class="d-flex gap-2 mb-4">

            <input type="text" name="search" class="form-control" placeholder="Cari No Kamar..."
                value="{{ request('search') }}">

            <select name="type" class="form-control" onchange="this.form.submit()">

                <option value="">Semua Tipe</option>
                <option value="standard" {{ request('type') == 'standard' ? 'selected' : '' }}>
                    Standard
                </option>
                <option value="deluxe" {{ request('type') == 'deluxe' ? 'selected' : '' }}>
                    Deluxe
                </option>
                <option value="suite" {{ request('type') == 'suite' ? 'selected' : '' }}>
                    Suite
                </option>

            </select>

            <select name="status" class="form-control" onchange="this.form.submit()">

                <option value="">Semua Status</option>
                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>
                    Tersedia
                </option>
                <option value="booking" {{ request('status') == 'booking' ? 'selected' : '' }}>
                    Booking
                </option>
                <option value="tidak" {{ request('status') == 'tidak' ? 'selected' : '' }}>
                    Tidak Tersedia
                </option>

            </select>

            <button class="btn btn-dark">
                Cari
            </button>

        </form>

        {{-- POPUP DAFTAR KAMAR --}}
        <div id="room-detail-card" class="room-overlay d-none">

            <div class="room-modal">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h4 id="room-title" class="mb-0">
                        Detail Kamar
                    </h4>

                    <button type="button" class="btn-close" onclick="closeRooms()">
                    </button>

                </div>

                <div class="mb-3">
                    <span class="badge bg-success">Tersedia</span>
                    <span class="badge bg-secondary">Terisi</span>
                    <span class="badge bg-dark">Maintenance</span>
                </div>

                <div id="room-grid" class="room-grid">
                </div>

            </div>

        </div>

        {{-- TABEL --}}
        <div class="card shadow-sm rounded-3">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover text-center align-middle">

                        <thead class="text-muted small">
                            <tr>
                                <th>No</th>
                                <th>Tipe Kamar</th>
                                <th>Sub Tipe</th>
                                <th>Harga</th>
                                <th>Kapasitas</th>
                                <th>Jumlah Kamar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($rooms as $i => $room)

                            <tr>

                                <td>{{ $i + 1 }}</td>

                                <td>
                                    {{ $room->room->title ?? '-' }}
                                </td>

                                <td>
                                    {{ $room->name }}
                                </td>

                                <td>
                                    Rp {{ number_format($room->price, 0, ',', '.') }}
                                </td>

                                <td>
                                    {{ $room->capacity }} Orang
                                </td>

                                <td>
                                    {{ $room->rooms_count ?? 0 }}
                                </td>

                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- Daftar Kamar --}}
                                        <button type="button" class="btn btn-outline-secondary btn-action"
                                            title="Daftar Kamar" onclick='showRooms(
        "{{ $room->name }}",
        @json($room->roomNumbers)
    )'>

                                            <i class="bi bi-door-open"></i>

                                        </button>

                                        {{-- Edit --}}
                                        <a href="#" class="btn btn-outline-primary btn-action" title="Edit">

                                            <i class="bi bi-pencil-square"></i>

                                        </a>

                                        {{-- Hapus --}}
                                        <button class="btn btn-outline-danger btn-action" title="Hapus">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </div>

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="7" class="py-5 text-muted">
                                    Belum ada data kamar
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    function showRooms(name, rooms) {
        document
            .getElementById('room-detail-card')
            .classList.remove('d-none');

        document
            .getElementById('room-title')
            .innerHTML = name;

        let html = '';

        rooms.forEach(room => {

            let statusClass = '';

            if (room.status === 'tersedia') {
                statusClass = 'available';
            } else if (room.status === 'terisi') {
                statusClass = 'occupied';
            } else {
                statusClass = 'maintenance';
            }

            html += `
            <div class="room-box ${statusClass}">
                ${room.room_number}
            </div>
        `;
        });

        document
            .getElementById('room-grid')
            .innerHTML = html;
    }

    function closeRooms() {
        document
            .getElementById('room-detail-card')
            .classList.add('d-none');
    }
</script>

@endsection