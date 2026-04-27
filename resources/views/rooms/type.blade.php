@extends('layouts.app')

@section('title', 'Detail Tipe Kamar')

@section('content')

@php
$roomTypes = [
    'standard' => [
        'title' => 'Standard Room',
        'description' => 'Kamar Standard adalah pilihan ideal untuk tamu yang mengutamakan kenyamanan dasar dengan harga terjangkau. Cocok untuk perjalanan bisnis singkat atau liburan hemat.',
        'sub_rooms' => [
            [
                'name' => 'Standard Twin',
                'desc' => 'Memiliki 2 kasur terpisah, cocok untuk teman atau rekan kerja yang sedang dinas di Batam.',
                'size' => '20 m²',
                'image' => 'standar1.png',
            ],
            [
                'name' => 'Standard Queen',
                'desc' => 'Memiliki 1 kasur besar menghadap ke area taman dalam hotel yang lebih tenang.',
                'size' => '24 m²',
                'image' => 'standar2.png',
            ],
        ],
        'facilities' => [
            'AC',
            'WiFi Gratis',
            'TV LED 32 inch',
            'Kamar mandi shower air panas/dingin',
            'Air mineral gratis'
        ]
    ],

    'deluxe' => [
        'title' => 'Deluxe Room',
        'description' => 'Deluxe Room menawarkan kenyamanan lebih dengan ruang yang lebih luas dan fasilitas premium untuk pengalaman menginap yang lebih santai dan elegan.',
        'sub_rooms' => [
            [
                'name' => 'Deluxe Executive',
                'desc' => 'Dilengkapi dengan meja kerja yang lebih luas dan kursi ergonomis untuk tamu yang butuh bekerja.',
                'size' => '32 m²',
                'image' => 'deluxe1.png',
            ],
            [
                'name' => 'Deluxe Balcony',
                'desc' => 'Kamar dengan akses balkon pribadi untuk menikmati udara luar secara langsung.',
                'size' => '35 m²',
                'image' => 'deluxe2.png',
            ],
        ],
        'facilities' => [
            'AC',
            'WiFi Premium',
            'Smart TV 43 inch',
            'Mini Bar',
            'Coffee & Tea Maker',
            'Sofa area'
        ]
    ],

    'suite' => [
        'title' => 'Suite Room',
        'description' => 'Suite Room adalah pilihan paling mewah dengan ruang tamu terpisah, fasilitas eksklusif, dan desain elegan untuk pengalaman menginap kelas premium.',
        'sub_rooms' => [
            [
                'name' => 'Executive Suite',
                'desc' => 'Memiliki ruang tamu (living room) terpisah untuk menerima tamu atau bersantai dengan sofa mewah.',
                'size' => '48 m²',
                'image' => 'suite1.png',
            ],
            [
                'name' => 'Panoramic Suite',
                'desc' => 'Terletak di sudut bangunan (corner room) sehingga memiliki pemandangan 180 derajat ke arah laut atau kota.',
                'size' => '60 m²',
                'image' => 'suite2.png',
            ],
        ],
        'facilities' => [
            'Living Room Terpisah',
            'Bathtub + Rain Shower',
            'Balcony Pribadi',
            'VIP Service',
            'Mini Kitchen',
            'Bathrobe & Slipper'
        ]
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