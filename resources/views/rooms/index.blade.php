@extends('layouts.app')

@section('content')
<div class="rooms-search">
    <div class="search-box">
        <input type="date" class="form-control" placeholder="Check-In">
        <input type="date" class="form-control" placeholder="Check-Out">

        <div class="guest-wrapper">
            <div class="guest-box" onclick="toggleGuest()">
                <i class="bi bi-person"></i>
                <span id="guestText">2 Dewasa, 0 Anak</span>
            </div>

            <div class="guest-dropdown" id="guestDropdown">
                <div class="guest-row">
                    <span>Dewasa</span>
                    <div class="counter">
                        <button onclick="changeValue('adult', -1)">-</button>
                        <span id="adult">2</span>
                        <button onclick="changeValue('adult', 1)">+</button>
                    </div>
                </div>

                <div class="guest-row">
                    <span>Anak</span>
                    <div class="counter">
                        <button onclick="changeValue('child', -1)">-</button>
                        <span id="child">0</span>
                        <button onclick="changeValue('child', 1)">+</button>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn-search">Cari Kamar</button>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3 mb-3">
                <h6>Rentang Harga</h6>
                <input type="range" class="form-range" min="200000" max="2200000" step="50000" value="800000" id="priceRange">
                <div class="d-flex justify-content-between mt-2">
                    <small>Rp 0</small>
                    <small id="priceValue">Rp 800.000</small>
                </div>
            </div>

            <div class="card p-3 mb-3">
                <h6>Fasilitas Hotel</h6>
                <label><input type="checkbox"> Restoran</label><br>
                <label><input type="checkbox"> Sarapan</label><br>
                <label><input type="checkbox"> Kolam Renang</label><br>
                <label><input type="checkbox"> Coffee Shop</label><br>
            </div>

            <div class="card p-3">
                <h6>Fasilitas Kamar</h6>
                <label><input type="checkbox"> AC</label><br>
                <label><input type="checkbox"> Kulkas</label><br>
                <label><input type="checkbox"> Bathub</label><br>
                <label><input type="checkbox"> Dapur</label><br>
                <label><input type="checkbox"> Tempat tidur bayi</label><br>

            </div>
        </div>

        <div class="col-md-9">
            @foreach($rooms as $room)
            <div class="card mb-4 p-3">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <img src="{{ asset('images/'.$room->image) }}" class="img-fluid rounded" alt="{{ $room->name }}">
                    </div>
                    <div class="col-md-5">
                        <h5>{{ $room->name }}</h5>
                        <p class="text-primary fw-bold">Rp {{ number_format($room->price, 0, ',', '.') }}/malam</p>
                    </div>
                    <div class="col-md-3 text-end">
                        <a href="/rooms/{{ $room->id }}" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection {{-- SELESAI DI SINI --}}

@push('scripts')
<script>
    // Script untuk Price Range
    const priceRange = document.getElementById('priceRange');
    const priceValue = document.getElementById('priceValue');

    if(priceRange) {
        priceRange.addEventListener('input', function () {
            let harga = Number(this.value).toLocaleString('id-ID');
            priceValue.innerText = 'Rp ' + harga;
        });
    }

    // Fungsi Toggle Guest (Tambahkan jika belum ada)
    function toggleGuest() {
        const dropdown = document.getElementById('guestDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }
</script>
@endpush