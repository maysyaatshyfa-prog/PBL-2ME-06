@extends('layouts.app')

@section('title', 'Home')

@section('content')

{{-- Navbar --}}
@include('components.navbar')

<!-- HERO -->
<section class="hero-section">
    <div class="container text-center">

        <!-- TEKS -->
        <div class="hero-text">
            <h1 class="hero-title">
                Booking Hotel Mudah <br>
                & Cepat
            </h1>
            <p class="hero-subtitle">
                Temukan Kamar Terbaik untuk Anda
            </p>
        </div>

        <div class="search-labels">
            <span>Check-in</span>
            <span>Check-out</span>
            <span>Tamu</span>
        </div>
        <div class="search-box">

            <input type="date" class="form-control" placeholder="Check-In">
            <input type="date" class="form-control" placeholder="Check-Out">

            <div class="guest-wrapper">
                <div class="guest-box" onclick="toggleGuest()">
                    <i class="bi bi-person"></i>
                    <span id="guestText">2 Dewasa, 0 Anak</span>
                </div>

                <!--dropdown-->
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
</section>
<div class="room-section">

    <h2 class="section-title">Temukan Kamar Terbaik</h2>

    <div class="room-container">
        <div class="room-card">
            <img src="/images/STANDAR.jpeg" alt="">
            <h5>Standard Room</h5>
            <p>Rp.700.000 / malam</p>
            <button>Lihat Detail</button>
        </div>
        <div class="room-card">
            <img src="/images/DULEXE.jpeg" alt="">
            <h5>Deluxe Room</h5>
            <p>Rp.1.000.000 / malam</p>
            <button>Lihat Detail</button>
        </div>

        <div class="room-card">
            <img src="/images/SUITE.jpg" alt="">
            <h5>Suite Room</h5>
            <p>Rp.1.400.000 / malam</p>
            <button>Lihat Detail</button>
        </div>
    </div>
</div>

<section class="superior-section">

    <h2 class="section-title">Fasilitas Utama</h2>

    <div class="superior-container">
        <div class="superior-card">
            <i class="bi bi-wifi"></i>
            <h5>Free WiFi</h5>
            <p>Koneksi stabil 24 jam</p> 
        </div>
        <div class="superior-card">
            <i class="bi bi-wind"></i>
            <h5>Full AC</h5>
            <p>Kesejukan di setiap sudut</p>  
        </div>

        <div class="superior-card">
            <i class="bi bi-tv"></i>
            <h5>Smart TV</h5>
            <p>Hiburan tanpa batas</p>
        </div>
        <div class="superior-card">
            <i class="bi bi-cup-hot"></i>
            <h5>Sarapan Gratis</h5>
            <p>Menu lezat setiap pagi</p>
        </div>
        <div class="superior-card">
            <i class="bi bi-p-circle"></i>
            <h5>Parkir</h5>
            <p>Luas dan terjaga aman</p>
        </div>
        <div class="superior-card">
            <i class="bi bi-water"></i>
            <h5>Kolam Renang</h5>
            <p>Segar dan eksklusif</p>
        </div>
    </div>
</section>
<section class="gallery-section">
    <div class="container">
        <h2 class="section-title">Galeri Aktivitas</h2>

        <div class="gallery-grid">
            <img src="/images/balkon.png">
            <img src="/images/kolam.jpg">
            <img src="/images/loby.jpg">
            <img src="/images/restoran.jfif">
            <img src="/images/tamu.jpg">
            <img src="/images/rooftop.jpg">
            <img src="/images/spa.jpg">
            <img src="/images/gym.jfif">
        </div>
    </div>
</section>

{{-- Footer --}}
@include('components.footer')

@endsection

@push('scripts')
<script>
    let adult = 2;
    let child = 0;

    function toggleGuest() {
        const dropdown = document.getElementById('guestDropdown');
        dropdown.style.display =
            dropdown.style.display === 'block' ? 'none' : 'block';
    }

    function changeValue(type, val) {

        if (type === 'adult') {
            adult = Math.max(1, adult + val);
            document.getElementById('adult').innerText = adult;
        }

        if (type === 'child') {
            child = Math.max(0, child + val);
            document.getElementById('child').innerText = child;
        }

        document.getElementById('guestText').innerText =
            `${adult} Dewasa, ${child} Anak`;
    }
</script>
@endpush