@extends('layouts.app')

@section('title', 'Konfirmasi Pemesanan')

@section('content')

<div class="container py-5">

    <div class="row">

        <!-- KIRI -->
        <div class="col-lg-8">

            <div class="card shadow-sm border-0 rounded-4 p-4">

                <h2 class="fw-bold mb-2">Konfirmasi Pemesanan</h2>
                <p class="text-muted mb-4">
                    Periksa kembali detail pemesanan Anda sebelum melanjutkan ke pembayaran.
                </p>

                <!-- Data Pemesan -->
                <h4 class="mb-3">Data Pemesan</h4>

                <div class="border rounded-4 p-3 mb-4">

                    <div class="row mb-2">
                        <div class="col-4">Nama Lengkap</div>
                        <div class="col-8 fw-semibold">{{ request('nama') }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-4">Email</div>
                        <div class="col-8 fw-semibold">{{ request('email') }}</div>
                    </div>

                    <div class="row">
                        <div class="col-4">No. Handphone</div>
                        <div class="col-8 fw-semibold">{{ request('phone') }}</div>
                    </div>

                </div>

                <!-- Data Tamu -->
                <h4 class="mb-3">Data Tamu yang Menginap</h4>

                <div class="border rounded-4 p-3 mb-4">

                    <div class="row mb-2">
                        <div class="col-4">Nama Tamu</div>
                        <div class="col-8 fw-semibold">{{ request('guest_name') }}</div>
                    </div>

                    <div class="row">
                        <div class="col-4">Permintaan Khusus</div>
                        <div class="col-8 fw-semibold">
                            {{ request('special_request') ?? '-' }}
                        </div>
                    </div>

                </div>

                <!-- Metode Pembayaran -->
                <h4 class="mb-3">Pilih Metode Pembayaran</h4>

                <form action="{{ route('payment.page') }}" method="GET">

                    <div class="row g-3 mb-4">

                        <div class="col-md-4">
                            <label class="payment-card">
                                <input type="radio" name="payment_method" value="transfer" required>
                                <h5>Transfer Bank</h5>
                                <p>Transfer melalui rekening bank.</p>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <label class="payment-card">
                                <input type="radio" name="payment_method" value="qris">
                                <h5>QRIS</h5>
                                <p>Bayar dengan scan QRIS.</p>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <label class="payment-card">
                                <input type="radio" name="payment_method" value="hotel">
                                <h5>Bayar di Hotel</h5>
                                <p>Pembayaran saat check-in.</p>
                            </label>
                        </div>

                    </div>

                    <div class="d-flex gap-3">

                        <a href="{{ url()->previous() }}"
                           class="btn btn-outline-secondary flex-fill">
                            Kembali
                        </a>

                        <button type="submit"
                                class="btn btn-primary flex-fill">
                            Lanjut ke Pembayaran
                        </button>

                    </div>

                </form>

            </div>

        </div>

        <!-- KANAN -->
        <div class="col-lg-4">

            <div class="card shadow-sm border-0 rounded-4 p-4">

                <h4 class="fw-bold mb-4">Ringkasan Pesanan</h4>

                <img src="{{ asset($variant->image) }}"
                     class="img-fluid rounded mb-3">

                <h5>{{ $variant->name }}</h5>

                <div class="d-flex justify-content-between mt-3">
                    <span>Check-in</span>
                    <strong>{{ $checkin }}</strong>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <span>Check-out</span>
                    <strong>{{ $checkout }}</strong>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <span>Tamu</span>
                    <strong>{{ $adult }} Dewasa, {{ $child }} Anak</strong>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <span>Durasi</span>
                    <strong>{{ $duration }} Malam</strong>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <h5>Total Harga</h5>
                    <h3 class="fw-bold text-primary">
                        Rp {{ number_format($totalPrice,0,',','.') }}
                    </h3>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection
