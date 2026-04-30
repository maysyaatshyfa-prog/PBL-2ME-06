@extends('layouts.app')

@section('content')

@include('components.navbar')

<main class="room-detail-page">

    <!-- HERO / BREADCRUMB -->
    <section class="detail-hero">
        <div class="container">

            <h1 class="room-title">
                {{ $variant->name }}
            </h1>
            <p class="room-subtitle">
                {{ $variant->room->title }}
            </p>
        </div>
    </section>


    <!-- MAIN DETAIL -->
    <section class="room-detail-section">
        <div class="container">
            <div class="detail-grid">
                <!-- Pembuka Grid Utama -->

                <!-- LEFT CONTENT -->
                <div class="detail-left">
                    <!-- Gallery -->
                    <div class="room-gallery">
                        <div class="main-image">
                            <img src="{{ asset('images/'.$variant->image) }}">
                        </div>
                        <div class="thumbnail-list">
                            @foreach(json_decode($variant->gallery ?? '[]') as $img)
                            <img src="{{ asset('images/'.$img) }}">
                            @endforeach
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="detail-card">
                        <h3>Deskripsi Kamar</h3>
                        <p>{{ $variant->room->description }}</p>
                    </div>

                    <!-- Facilities -->
                    <div class="detail-card">
                        <h3>Fasilitas Kamar</h3>
                        <div class="facility-list">
                            <span>Wifi Gratis</span>
                            <span>AC</span>
                            <span>TV LED</span>
                            <span>Shower</span>
                            <span>Breakfast</span>
                            <span>Meja Kerja</span>
                            <span>Lemari</span>
                            <span>Air Mineral</span>
                        </div>
                    </div>

                    <!-- Policy -->
                    <div class="detail-card">
                        <h3>Kebijakan Hotel</h3>
                        <ul>
                            <li>Check-in mulai pukul 14:00</li>
                            <li>Check-out maksimal pukul 12:00</li>
                            <li>Dilarang merokok di dalam kamar</li>
                            <li>Pembatalan sesuai syarat hotel</li>
                        </ul>
                    </div>
                </div> <!-- PENUTUP detail-left (PENTING: Harus di sini) -->

                <!-- RIGHT SIDEBAR -->
                <div class="detail-right">
                    <div class="booking-card">
                        <h3>Ringkasan Reservasi</h3>

                        <div class="booking-item">
                            <span>Check-in</span>
                            <strong>{{ request('checkin') ?: '-' }}</strong>
                        </div>

                        <div class="booking-item">
                            <span>Check-out</span>
                            <strong>{{ request('checkout') ?: '-' }}</strong>
                        </div>

                        <div class="booking-item">
                            <span>Tamu</span>
                            <strong>
                                {{ request('adult', 2) }} Dewasa,
                                {{ request('child', 0) }} Anak
                            </strong>
                        </div>

                        <div class="booking-item">
                            <span>Durasi</span>
                            <strong>
                                @php
                                $checkin = request('checkin');
                                $checkout = request('checkout');
                                $night = ($checkin && $checkout) ?
                                \Carbon\Carbon::parse($checkin)->diffInDays(\Carbon\Carbon::parse($checkout)) : 1;
                                @endphp
                                {{ $night }} Malam
                            </strong>
                        </div>

                        <hr>

                        <div class="price-box">
                            <small>Rp {{ number_format($variant->price,0,',','.') }} / malam</small>
                            <h2>Rp {{ number_format($variant->price * $night,0,',','.') }}</h2>
                        </div>

                        <a href="/reservation-form" class="btn-book">Pesan Sekarang</a>

                        <a href="/rooms?checkin={{ request('checkin') }}&checkout={{ request('checkout') }}&adult={{ request('adult',2) }}&child={{ request('child',0) }}"
                            class="change-date">
                            Ubah Pencarian
                        </a>
                    </div>
                </div> <!-- PENUTUP detail-right -->

            </div> <!-- PENUTUP detail-grid -->
        </div> <!-- PENUTUP container -->
    </section>

</main>
{{-- Footer --}}
@include('components.footer')

@endsection