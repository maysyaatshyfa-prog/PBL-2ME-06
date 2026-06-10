@extends('layouts.app')

@section('content')
@include('components.navbar')

<div class="container py-5">

    <div class="success-wrapper">

        <div class="success-card text-center mb-4">

            <div class="success-icon">
                <i class="bi bi-check-lg"></i>
            </div>

            <h2 class="success-title">
                Pembayaran Berhasil
            </h2>

            <p class="success-text">
                Terima kasih. Reservasi Anda telah berhasil dibuat dan pembayaran telah diterima.
            </p>

            <span class="badge-paid">
                LUNAS
            </span>

        </div>

        <div class="box-card">

            <h5 class="fw-bold mb-4">
                Detail Reservasi
            </h5>

            <div class="detail-item">
                <span>Kode Booking</span>
                <strong>RSV-{{ date('YmdHis') }}</strong>
            </div>

            <div class="detail-item">
                <span>Nama Pemesan</span>
                <strong>{{ auth()->user()->name ?? '-' }}</strong>
            </div>

            <div class="detail-item">
                <span>Status Pembayaran</span>
                <strong class="text-success">Lunas</strong>
            </div>

            <div class="detail-item">
                <span>Tanggal Reservasi</span>
                <strong>{{ now()->format('d M Y H:i') }}</strong>
            </div>

            <hr>

            <div class="alert alert-light border mt-3">
                <strong>Informasi:</strong><br>
                Silakan tunjukkan kode booking saat check-in.
                Detail reservasi juga dapat dilihat pada menu
                <strong>Riwayat Booking</strong>.
            </div>

            <div class="d-flex justify-content-center gap-2 mt-4">

                <a href="{{ route('bookinghistory.index') }}" class="btn btn-primary action-btn">
                    Lihat Reservasi Saya
                </a>

                <a href="{{ url('/') }}" class="btn btn-outline-secondary action-btn">
                    Kembali ke Beranda
                </a>

            </div>

        </div>

    </div>

</div>
@endsection