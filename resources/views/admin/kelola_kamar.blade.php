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
            <a href="/rooms/create" class="btn btn-dark">
                + Tambah Kamar
            </a>
        </div>

        {{-- FILTER + SEARCH --}}
        <form method="GET" action="{{ route('rooms.index') }}" class="d-flex gap-2 mb-4">

            {{-- SEARCH --}}
            <input 
                type="text" 
                name="search" 
                class="form-control"
                placeholder="Cari No Kamar..."
                value="{{ request('search') }}"
            >

            {{-- TIPE --}}
            <select name="type" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Tipe</option>
                <option value="standard" {{ request('type') == 'standard' ? 'selected' : '' }}>Standard</option>
                <option value="deluxe" {{ request('type') == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                <option value="suite" {{ request('type') == 'suite' ? 'selected' : '' }}>Suite</option>
            </select>

            {{-- STATUS --}}
            <select name="status" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="booking" {{ request('status') == 'booking' ? 'selected' : '' }}>Booking</option>
                <option value="tidak" {{ request('status') == 'tidak' ? 'selected' : '' }}>Tidak Tersedia</option>
            </select>

            <button class="btn btn-dark">Cari</button>

        </form>

        {{-- CARD --}}
        <div class="card shadow-sm rounded-3">
            <div class="card-body">

                <h5 class="mb-3 fw-semibold">Daftar Kamar</h5>

                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle">

                        <thead class="text-muted small">
                            <tr>
                                <th>No</th>
                                <th>No Kamar</th>
                                <th>Tipe</th>
                                <th>Sub Tipe</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                        @forelse($rooms as $i => $room)
                            <tr>

                                <td>{{ $i + 1 }}</td>

                                {{-- NOMOR --}}
                                <td class="fw-semibold">
                                    {{ $room->number ?? '-' }}
                                </td>

                                {{-- TIPE --}}
                                <td>
                                    {{ optional(optional($room->variant)->room)->title ?? '-' }}
                                </td>

                                {{-- SUB TIPE --}}
                                <td>
                                    {{ optional($room->variant)->name ?? '-' }}
                                </td>

                                {{-- HARGA --}}
                                <td>
                                    Rp {{ number_format(optional($room->variant)->price ?? 0, 0, ',', '.') }}
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    @if($room->status == 'tersedia')
                                        <span class="badge bg-success">Tersedia</span>
                                    @elseif($room->status == 'booking')
                                        <span class="badge bg-warning text-dark">Booking</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Tersedia</span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <div class="d-flex justify-content-center gap-2">

                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="#" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="py-5 text-muted">
                                    <i class="bi bi-door-closed d-block mb-2" style="font-size:2rem;"></i>
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

@endsection