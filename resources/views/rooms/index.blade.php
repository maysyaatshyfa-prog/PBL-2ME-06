@extends('layouts.app')

@section('content')
{{-- Navbar --}}
@include('components.navbar')

<form method="GET" action="{{ route('rooms.index') }}">


    <input type="hidden" name="adult" id="input_adult" value="{{ request('adult', 2) }}">
    <input type="hidden" name="child" id="input_child" value="{{ request('child', 0) }}">

    <div class="rooms-search">
        <div class="search-box">

            <input type="date" name="checkin" class="form-control" value="{{ request('checkin') }}">

            <input type="date" name="checkout" class="form-control" value="{{ request('checkout') }}">

            <div class="guest-wrapper">
                <div class="guest-box" onclick="toggleGuest(event)">
                    <i class="bi bi-person"></i>

                    <span id="guestText">
                        {{ request('adult', 2) }} Dewasa, {{ request('child', 0) }} Anak
                    </span>
                </div>

                <div class="guest-dropdown" id="guestDropdown" onclick="event.stopPropagation()">

                    <div class="guest-row">
                        <span>Dewasa</span>
                        <div class="counter">
                            <button type="button" onclick="changeValue('adult', -1)">-</button>
                            <span id="adult">{{ request('adult', 2) }}</span>
                            <button type="button" onclick="changeValue('adult', 1)">+</button>
                        </div>
                    </div>

                    <div class="guest-row">
                        <span>Anak</span>
                        <div class="counter">
                            <button type="button" onclick="changeValue('child', -1)">-</button>
                            <span id="child">{{ request('child', 0) }}</span>
                            <button type="button" onclick="changeValue('child', 1)">+</button>
                        </div>
                    </div>

                </div>
            </div>

            <button type="submit" class="btn-search">Cari Kamar</button>
        </div>
    </div>


</form>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3 mb-3">
                <h6>Rentang Harga</h6>
                <input type="range" class="form-range" min="200000" max="2200000" step="50000" value="800000"
                    id="priceRange">
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
                        <img src="{{ asset('images/'.$room->image) }}" class="img-fluid rounded"
                            alt="{{ $room->name }}">
                    </div>
                    <div class="col-md-5">
                        <h5>{{ $room->name }}</h5>

                        <p class="text-primary fw-bold">
                            Rp {{ number_format((int)$room->price, 0, ',', '.') }}/malam
                        </p>
                    </div>
                    <div class="col-md-3 text-end">
                        <a href="/rooms/{{ $room->id }}" class="btn btn-primary">Pilih</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let adult = parseInt(document.getElementById('input_adult') ? .value || 2);
    let child = parseInt(document.getElementById('input_child') ? .value || 0);

    function toggleGuest(event) {
        event.stopPropagation();

        const dropdown = document.getElementById('guestDropdown');
        dropdown.style.display =
            dropdown.style.display === 'block' ? 'none' : 'block';
    }

    function changeValue(type, val) {

        if (type === 'adult') {
            adult = Math.max(1, adult + val);
            document.getElementById('adult').innerText = adult;
            document.getElementById('input_adult').value = adult;
        }

        if (type === 'child') {
            child = Math.max(0, child + val);
            document.getElementById('child').innerText = child;
            document.getElementById('input_child').value = child;
        }

        document.getElementById('guestText').innerText =
            `${adult} Dewasa, ${child} Anak`;
    }

    // klik luar tutup dropdown
    document.addEventListener('click', function () {
        document.getElementById('guestDropdown').style.display = 'none';
    });
    // Script untuk Price Range
    const priceRange = document.getElementById('priceRange');
    const priceValue = document.getElementById('priceValue');

    if (priceRange) {
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