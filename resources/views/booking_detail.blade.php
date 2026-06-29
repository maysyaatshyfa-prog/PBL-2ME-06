@extends('layouts.app')

@section('content')
@include('components.navbar')

<div class="container py-5">
    <div class="success-wrapper">

        {{-- HEADER --}}
        <div class="success-card text-center mb-4">

            <div class="detail-icon">
                <i class="bi bi-calendar-check"></i>
            </div>

            <h2 class="success-title">
                Detail Reservasi
            </h2>

            <p class="success-text">
                Informasi lengkap reservasi kamar Anda.
            </p>

            <span class="badge-reservation">
                {{ $booking->status_pembayaran }}
            </span>

        </div>

        {{-- DETAIL --}}
        <div class="box-card">
            @if($booking->roomVariant && $booking->roomVariant->image)

            <div class="text-center mb-4">
                <img src="{{ asset('images/' . $booking->roomVariant->image) }}" alt="Room Image"
                    class="img-fluid rounded-4 shadow" style="width:100%;height:350px;object-fit:cover;">
            </div>

            @else

            <div class="text-center mb-4">
                <img src="{{ asset('images/standar1.png') }}" alt="No Image" class="img-fluid rounded-4 shadow"
                    style="width:100%;height:350px;object-fit:cover;">
            </div>

            @endif

            <h5 class="fw-bold mb-4">
                Informasi Reservasi
            </h5>

            <div class="detail-item">
                <span>Kode Reservasi : </span>
                <strong>
                    RSV-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                </strong>
            </div>

            <div class="detail-item">
                <span>Kode Pembayaran :</span>
                <strong>
                    PAY-{{ date('Ymd') }}-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                </strong>
            </div>

            <div class="detail-item">
                <span>Nama Pemesan :</span>
                <strong>
                    {{ $booking->user->name ?? '-' }}
                </strong>
            </div>

            <div class="detail-item">
                <span>Tipe Kamar :</span>
                <strong>
                    {{ $booking->roomVariant->name ?? '-' }}
                </strong>
            </div>

            <div class="detail-item">
                <span>Check In :</span>
                <strong>
                    {{ \Carbon\Carbon::parse($booking->check_in)->translatedFormat('d F Y') }}
                </strong>
            </div>

            <div class="detail-item">
                <span>Check Out :</span>
                <strong>
                    {{ \Carbon\Carbon::parse($booking->check_out)->translatedFormat('d F Y') }}
                </strong>
            </div>

            <div class="detail-item">
                <span>Total Pembayaran :</span>
                <strong class="text-success">
                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                </strong>
            </div>

            <div class="detail-item">
                <span>Status Pembayaran :</span>
                <strong class="text-success">
                    {{ $booking->status_pembayaran }}
                </strong>
            </div>

            @if($booking->status_pembayaran == 'Lunas')

            <hr>

            <h5 class="fw-bold mb-3">Upload KTP</h5>

            @if(!$booking->ktp)

            <form action="{{ route('booking.uploadKtp', $booking->id) }}" method="POST" enctype="multipart/form-data">

                @csrf

                <input type="file" name="ktp" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>

                <button type="submit" class="btn btn-primary mt-3">
                    Upload KTP
                </button>

            </form>

            @else

            <div class="alert alert-success">
                ✅ KTP sudah diupload.
            </div>

            <a href="{{ asset('storage/ktp/'.$booking->ktp) }}" target="_blank" class="btn btn-outline-primary">
                Lihat KTP
            </a>

            @endif

            @endif

            <div class="detail-item">
                <span>Tanggal Reservasi :</span>
                <strong>
                    {{ $booking->created_at->format('d M Y H:i') }}
                </strong>
            </div>

            <hr>

            <div class="alert alert-light border mt-3">
                <strong>Informasi:</strong><br>
                Silakan tunjukkan kode booking saat check-in.
                Jika ada perubahan reservasi, silakan hubungi admin hotel.
            </div>

            <div class="d-flex justify-content-center gap-2 mt-4">

                <a href="{{ route('bookinghistory.index') }}" class="btn btn-primary action-btn">
                    Kembali ke Riwayat
                </a>

                <a href="{{ url('/') }}" class="btn btn-outline-secondary action-btn">
                    Kembali ke Beranda
                </a>

            </div>

        </div>

    </div>


</div>
@endsection
