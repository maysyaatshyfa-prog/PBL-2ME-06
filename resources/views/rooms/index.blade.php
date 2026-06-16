@extends('layouts.app')

@section('content')

{{-- Navbar --}}
@include('components.navbar')

<form method="GET" action="{{ route('rooms.index') }}" class="rooms-search" id="filterForm">

    <input type="hidden" name="adult" id="input_adult" value="{{ request('adult',2) }}">
    <input type="hidden" name="child" id="input_child" value="{{ request('child',0) }}">

    <div class="search-box">

        <input type="date" name="checkin" class="form-control" value="{{ request('checkin') }}">

        <input type="date" name="checkout" class="form-control" value="{{ request('checkout') }}">

        <div class="guest-wrapper">
            <div class="guest-box" onclick="toggleGuest(event)">
                <i class="bi bi-person"></i>
                <span id="guestText">
                    {{ request('adult',2) }} Dewasa,
                    {{ request('child',0) }} Anak
                </span>
            </div>
        </div>

        <div class="guest-dropdown" id="guestDropdown" onclick="event.stopPropagation()">

            <div class="guest-row">
                <span>Dewasa</span>
                <div class="counter">
                    <button type="button" onclick="changeValue('adult', -1)">-</button>

                    <span id="adult">
                        {{ request('adult',2) }}
                    </span>

                    <button type="button" onclick="changeValue('adult', 1)">+</button>
                </div>
            </div>

            <div class="guest-row">
                <span>Anak</span>
                <div class="counter">
                    <button type="button" onclick="changeValue('child', -1)">-</button>

                    <span id="child">
                        {{ request('child',0) }}
                    </span>

                    <button type="button" onclick="changeValue('child', 1)">+</button>
                </div>
            </div>

        </div>

        <button type="submit" class="btn-search">
            Cari Kamar
        </button>

    </div>
</form>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3 mb-3">
                <h6>Rentang Harga</h6>
                <input type="range" class="form-range" min="200000" max="2200000" step="50000"
                    value="{{ request('price',800000) }}" id="priceRange" name="price" form="filterForm">
                <div class="d-flex justify-content-between mt-2">
                    <small>Rp 0</small>
                    <small id="priceValue">Rp 800.000</small>
                </div>
            </div>

            <div class="facility-box">
                <h6>Fasilitas</h6>

                @foreach($allFacilities as $facility)
                <label style="display:block;">
                    <input type="checkbox" name="facilities[]" value="{{ $facility }}"
                        {{ in_array($facility, request('facilities', [])) ? 'checked' : '' }}>
                    {{ $facility }}
                </label>
                @endforeach
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

                        @php
                        $available = $room->roomNumbers
                        ->where('status', 'tersedia')
                        ->count();
                        @endphp

                        @if($available == 0)
                        <p class="text-danger fw-bold mb-0">
                            Kamar Penuh
                        </p>
                        @elseif($available <= 20) <p class="text-warning fw-bold mb-0">
                            Tersisa {{ $available }} kamar lagi
                            </p>
                            @endif

                    </div>

                    <div class="col-md-3 text-end">

                        @if($available > 0)
                        <a href="{{ route('rooms.show', $room->id) }}?checkin={{ request('checkin') }}&checkout={{ request('checkout') }}&adult={{ request('adult',2) }}&child={{ request('child',0) }}"
                            class="btn btn-primary">
                            Pilih
                        </a>
                        @else
                        <button class="btn btn-secondary" disabled>
                            Pilih
                        </button>
                        @endif

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
    let adult = parseInt(document.getElementById("input_adult").value) || 2;
    let child = parseInt(document.getElementById("input_child").value) || 0;

    function toggleGuest(event) {

        event.stopPropagation();

        const dropdown =
            document.getElementById("guestDropdown");

        dropdown.style.display =
            dropdown.style.display === "block" ?
            "none" :
            "block";
    }

    function changeValue(type, val) {

        if (type === "adult") {

            adult = Math.max(1, adult + val);

            document.getElementById("adult").innerText =
                adult;

            document.getElementById("input_adult").value =
                adult;
        }

        if (type === "child") {

            child = Math.max(0, child + val);

            document.getElementById("child").innerText =
                child;

            document.getElementById("input_child").value =
                child;
        }

        document.getElementById("guestText").innerText =
            adult + " Dewasa, " +
            child + " Anak";

        document.getElementById("filterForm").submit();
    }

    document.addEventListener("click", function () {

        document.getElementById("guestDropdown")
            .style.display = "none";

    });

    const priceRange =
        document.getElementById("priceRange");

    const priceValue =
        document.getElementById("priceValue");

    if (priceRange) {

        let hargaAwal =
            Number(priceRange.value)
            .toLocaleString("id-ID");

        priceValue.innerText =
            "Rp " + hargaAwal;

        priceRange.addEventListener("input", function () {

            let harga =
                Number(this.value)
                .toLocaleString("id-ID");

            priceValue.innerText =
                "Rp " + harga;

        });

        priceRange.addEventListener("change", function () {
            document.getElementById("filterForm").submit();
        });
    }
</script>
@endpush