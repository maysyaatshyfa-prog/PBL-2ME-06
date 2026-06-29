@extends('layouts.app')

@section('content')

{{-- Navbar --}}
@include('components.navbar')

<form method="GET" action="{{ route('rooms.index') }}" class="rooms-search" id="filterForm">

    <form method="GET" action="{{ route('rooms.index') }}" id="filterForm">

        <input type="hidden" name="adult" id="input_adult" value="{{ request('adult',2) }}">

        <input type="hidden" name="child" id="input_child" value="{{ request('child',0) }}">

        <div class="search-box">

            <input type="date" name="checkin" class="form-control" min="{{ date('Y-m-d') }}"
                value="{{ request('checkin') }}">

            <input type="date" name="checkout" class="form-control" min="{{ date('Y-m-d') }}"
                value="{{ request('checkout') }}">

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

                    <div id="priceSlider"></div>

                    <div class="d-flex justify-content-between mt-2">
                        <small id="minPrice">Rp 0</small>
                        <small id="maxPrice">Rp 2.200.000</small>
                    </div>

                    <!-- ikut form filterForm -->
                    <input type="hidden" name="min_price" id="min_price" form="filterForm">

                    <input type="hidden" name="max_price" id="max_price" form="filterForm">

                    <button type="submit" form="filterForm" class="btn btn-outline-secondary mt-3 w-100">
                        Terapkan Harga
                    </button>
                </div>

                <div class="facility-box">
                    <h6>Fasilitas</h6>

                    @foreach($allFacilities as $facility)
                    <label class="d-block mb-2">

                        <input type="checkbox" name="facilities[]" value="{{ $facility }}" form="filterForm"
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
        const inputAdult = document.getElementById("input_adult");
        const inputChild = document.getElementById("input_child");

        let adult = parseInt(document.getElementById("input_adult").value) || 2;
        let child = parseInt(document.getElementById("input_child").value) || 0;

        function toggleGuest(event) {
            event.stopPropagation();

            const dropdown = document.getElementById("guestDropdown");

            dropdown.style.display =
                dropdown.style.display === "block" ?
                "none" :
                "block";
        }

        function changeValue(type, val) {

            if (type === "adult") {
                adult = Math.max(1, adult + val);

                document.getElementById("adult").innerText = adult;
                document.getElementById("input_adult").value = adult;
            }

            if (type === "child") {
                child = Math.max(0, child + val);

                document.getElementById("child").innerText = child;
                document.getElementById("input_child").value = child;
            }

            document.getElementById("guestText").innerText =
                adult + " Dewasa, " + child + " Anak";
        }

        document.addEventListener("click", function () {
            document.getElementById("guestDropdown").style.display = "none";
        });

        const slider = document.getElementById('priceSlider');

        if (slider) {

            noUiSlider.create(slider, {
                start: [
                    Number("{{ request('min_price', 0) }}"),
                    Number("{{ request('max_price', 2200000) }}")
                ],
                connect: true,
                step: 50000,
                range: {
                    min: 0,
                    max: 2200000
                }
            });
            const minPrice = document.getElementById('minPrice');
            const maxPrice = document.getElementById('maxPrice');

            const inputMin = document.getElementById('min_price');
            const inputMax = document.getElementById('max_price');

            slider.noUiSlider.on('update', function (values) {

                let min = Math.round(values[0]);
                let max = Math.round(values[1]);

                minPrice.innerText =
                    'Rp ' + min.toLocaleString('id-ID');

                maxPrice.innerText =
                    'Rp ' + max.toLocaleString('id-ID');

                inputMin.value = min;
                inputMax.value = max;
            });
        }
        // Filter otomatis saat fasilitas dipilih
        document.querySelectorAll('input[name="facilities[]"]').forEach(function (item) {

            item.addEventListener('change', function () {

                document.getElementById('filterForm').submit();

            });

        });
    </script>
    @endpush