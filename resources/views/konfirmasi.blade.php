@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran')

@section('content')

<div class="container py-4">

    <h2 class="mb-4">Konfirmasi Pembayaran</h2>

    <div class="row">

        {{-- DETAIL BOOKING --}}
        <div class="col-md-6">

            <div class="card p-3 mb-3">
                <h5>Detail Booking</h5>
                <hr>

                <p><strong>Kode Booking:</strong> {{ $booking->id }}</p>
                <p><strong>Tipe Kamar:</strong> {{ $booking->room->name ?? '-' }}</p>
                <p><strong>Check-in:</strong> {{ $booking->checkin }}</p>
                <p><strong>Check-out:</strong> {{ $booking->checkout }}</p>

                <p><strong>Total Harga:</strong> Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</p>
            </div>

        </div>

        {{-- PEMBAYARAN --}}
        <div class="col-md-6">

            <form action="{{ url('/payment/confirm/' . $booking->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card p-3 mb-3">

                    <h5>Metode Pembayaran</h5>
                    <hr>

                    {{-- PILIH METODE --}}
                    <div class="mb-3">

                        <label class="form-label">Pilih Metode</label>

                        <select name="payment_method" class="form-control" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="qris">QRIS</option>
                        </select>

                    </div>

                    {{-- TRANSFER BANK --}}
                    <div class="mb-3">
                        <h6>Transfer Bank</h6>
                        <p class="mb-1">Bank BCA</p>
                        <p class="mb-1">No Rekening: <strong>1234567890</strong></p>
                        <p>A/N: Hotel MarStay</p>
                    </div>

                    {{-- QRIS --}}
                    <div class="mb-3">
                        <h6>QRIS</h6>
                        <img src="{{ asset('images/qris.png') }}" alt="QRIS" style="width:200px;">
                        <p class="text-muted">Scan QR untuk pembayaran</p>
                    </div>

                    {{-- UPLOAD BUKTI --}}
                    <div class="mb-3">

                        <label class="form-label">Upload Bukti Pembayaran</label>
                        <input type="file" name="payment_proof" class="form-control" required>

                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        Kirim Konfirmasi Pembayaran
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection