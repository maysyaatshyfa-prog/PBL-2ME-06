@extends('layouts.app')

@section('title', 'Detail Reservasi')

@section('content')
@include('components.navbar')

<style>
    .nota-card { border-radius: 20px; transition: 0.3s; }
    .header-gradient { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); border-radius: 20px 20px 0 0; }
    .info-box { background: #f8f9fa; border-left: 4px solid #1e3c72; }
    .badge-modern { padding: 8px 20px; border-radius: 50px; font-weight: 600; font-size: 0.85rem; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10">
            
            <a href="{{ route('bookinghistory.index') }}" class="text-decoration-none text-muted mb-4 d-inline-block">
                <i class="fas fa-arrow-left"></i> ← Kembali ke Daftar Reservasi
            </a>

            <div class="nota-card shadow-lg bg-white overflow-hidden border-0">
                {{-- Header --}}
                <div class="header-gradient p-4 text-white text-center">
                    <h3 class="fw-bold mb-1">Reservation Confirmation</h3>
                    <p class="opacity-75 mb-0 text-uppercase tracking-wide">ID Booking: #{{ $booking->id }}</p>
                </div>

                {{-- Body --}}
                <div class="p-4 p-md-5">
                    
                    {{-- Status Bar --}}
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <span class="text-muted">Status Pembayaran</span>
                        <span class="badge-modern {{ ($booking->payment_status ?? 'Belum Bayar') == 'Lunas' ? 'bg-success text-white' : 'bg-warning text-dark' }}">
                            {{ $booking->payment_status ?? 'Belum Bayar' }}
                        </span>
                    </div>

                    {{-- Room Info --}}
                    <div class="info-box p-3 mb-4">
                        <small class="text-uppercase text-primary fw-bold d-block mb-1">Tipe Kamar</small>
                        <h4 class="fw-bold text-dark mb-0">{{ $booking->room->title ?? 'Standard Room' }}</h4>
                    </div>

                    {{-- Check-In & Out Grid --}}
                    <div class="row text-center mb-4">
                        <div class="col-6">
                            <div class="text-muted small">CHECK-IN</div>
                            <div class="fs-5 fw-bold text-dark">{{ \Carbon\Carbon::parse($booking->checkin)->format('d M, Y') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small">CHECK-OUT</div>
                            <div class="fs-5 fw-bold text-dark">{{ \Carbon\Carbon::parse($booking->checkout)->format('d M, Y') }}</div>
                        </div>
                    </div>

                    {{-- Footer Info --}}
                    <div class="bg-dark text-white p-4 rounded-3 text-center">
                        <p class="mb-0 small opacity-75">Terima kasih telah memilih MARStay</p>
                        <h6 class="mt-2 fw-bold">Selamat Beristirahat!</h6>
                    </div>

                </div>
            </div>

            {{-- Tombol Tindakan --}}
            <div class="text-center mt-4">
                <button onclick="window.print()" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="fas fa-print"></i> Cetak Nota
                </button>
            </div>

        </div>
    </div>
</div>
@endsection