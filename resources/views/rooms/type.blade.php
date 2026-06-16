@extends('layouts.app')

@section('title', 'Detail Tipe Kamar')

@section('content')
{{-- Navbar --}}
@include('components.navbar')

@php
$roomTypes = [

    'standard' => [
        'title' => 'Standard Room',
        'description' => 'Kamar Standard merupakan pilihan ideal bagi tamu yang menginginkan kenyamanan dengan harga yang terjangkau. Didesain dengan suasana yang hangat dan modern, tipe kamar ini cocok untuk perjalanan bisnis maupun liburan singkat bersama keluarga atau teman.',

        'sub_rooms' => [
            [
                'name' => 'Standard Twin',
                'desc' => 'Memiliki dua tempat tidur terpisah yang nyaman, cocok untuk teman perjalanan, rekan kerja, maupun tamu yang menginginkan ruang tidur terpisah.',
                'size' => '20 m²',
                'capacity' => '2 Dewasa',
                'bed' => '2 Single Bed',
                'view' => 'City View',
                'image' => 'standar1.png',
            ],
            [
                'name' => 'Standard Queen',
                'desc' => 'Dilengkapi satu tempat tidur ukuran queen yang nyaman dengan suasana kamar yang tenang dan cocok untuk pasangan maupun tamu individu.',
                'size' => '24 m²',
                'capacity' => '2 Dewasa',
                'bed' => '1 Queen Bed',
                'view' => 'Garden View',
                'image' => 'standar2.png',
            ],
        ],

        'facilities' => [
            'AC',
            'WiFi Gratis',
            'TV LED 32 Inch',
            'Kamar Mandi Shower Air Panas & Dingin',
            'Air Mineral Gratis',
            'Lemari Pakaian',
            'Meja Kerja',
            'Perlengkapan Mandi'
        ],

    ],

    'deluxe' => [
        'title' => 'Deluxe Room',
        'description' => 'Deluxe Room menawarkan ruang yang lebih luas dengan fasilitas yang lebih lengkap untuk memberikan pengalaman menginap yang lebih nyaman. Cocok untuk tamu yang menginginkan kenyamanan ekstra selama perjalanan bisnis maupun liburan.',

        'sub_rooms' => [
            [
                'name' => 'Deluxe Executive',
                'desc' => 'Dirancang khusus untuk tamu bisnis dengan area kerja yang lebih luas serta kursi ergonomis yang mendukung produktivitas selama menginap.',
                'size' => '32 m²',
                'capacity' => '2 Dewasa + 1 Anak',
                'bed' => '1 King Bed',
                'view' => 'City View',
                'image' => 'deluxe1.png',
            ],
            [
                'name' => 'Deluxe Balcony',
                'desc' => 'Memiliki balkon pribadi yang memberikan pengalaman menginap lebih santai sambil menikmati pemandangan kota maupun area sekitar hotel.',
                'size' => '35 m²',
                'capacity' => '2 Dewasa + 1 Anak',
                'bed' => '1 King Bed',
                'view' => 'Garden View',
                'image' => 'deluxe2.png',
            ],
        ],

        'facilities' => [
            'AC',
            'WiFi Premium',
            'Smart TV 43 Inch',
            'Mini Bar',
            'Coffee & Tea Maker',
            'Sofa Area',
            'Meja Kerja Eksekutif',
            'Safe Deposit Box',
            'Air Mineral Gratis'
        ],

    ],

    'suite' => [
        'title' => 'Suite Room',
        'description' => 'Suite Room merupakan pilihan kamar paling eksklusif dengan ruang yang luas, fasilitas premium, serta desain interior yang elegan. Cocok bagi tamu yang menginginkan kenyamanan maksimal dan pengalaman menginap kelas atas.',

        'sub_rooms' => [
            [
                'name' => 'Executive Suite',
                'desc' => 'Memiliki ruang tamu terpisah yang luas sehingga memberikan privasi lebih dan cocok untuk menerima tamu maupun bersantai bersama keluarga.',
                'size' => '48 m²',
                'capacity' => '3 Dewasa',
                'bed' => '1 King Bed',
                'view' => 'City View',
                'image' => 'suite1.png',
            ],
            [
                'name' => 'Panoramic Suite',
                'desc' => 'Terletak di sudut bangunan dengan jendela besar yang menawarkan pemandangan panorama kota maupun laut dari berbagai sisi kamar.',
                'size' => '60 m²',
                'capacity' => '4 Dewasa',
                'bed' => '1 King Bed',
                'view' => 'Sea & City View',
                'image' => 'suite2.png',
            ],
        ],

        'facilities' => [
            'Living Room Terpisah',
            'Bathtub & Rain Shower',
            'Balcony Pribadi',
            'VIP Service',
            'Mini Kitchen',
            'Bathrobe & Slipper',
            'Coffee Machine',
            'Smart TV 55 Inch',
            'Safe Deposit Box',
            'Mini Bar Premium'
        ],

    ],

];
$type = $roomTypes[$typeKey] ?? null;
@endphp

@if(!$type)
    <div class="container">
        <h2>Tipe kamar tidak ditemukan</h2>
    </div>
@else

<div class="container type-page">

    {{-- HEADER --}}
    <div class="type-header">

        <h1>{{ $type['title'] }}</h1>

        <p class="type-desc">
            {{ $type['description'] }}
        </p>

    </div>

    {{-- SUB ROOMS --}}
    <div class="sub-room-section">

        <h3>Varian Kamar</h3>

        <div class="sub-room-grid">

            @foreach($type['sub_rooms'] as $room)
            <div class="sub-room-card">

                <img src="{{ asset('images/' . $room['image']) }}">

                <h4>{{ $room['name'] }}</h4>

                <p>{{ $room['desc'] }}</p>

                <small>{{ $room['size'] }}</small>

            </div>
            @endforeach

        </div>

    </div>

    {{-- FACILITIES --}}
    <div class="facility-section">

        <h3>Fasilitas Tipe Kamar</h3>

        <div class="facility-grid">

            @foreach($type['facilities'] as $facility)
                <div class="facility">
                    ✔ {{ $facility }}
                </div>
            @endforeach

        </div>

    </div>

</div>

@endif

@endsection