@extends('layouts.app')
@section('title', 'Konfirmasi Pemesanan')
@section('content')

@include('components.navbar')

<div class="container py-5">

    {{-- Step --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <div class="step-number">4</div>
        <h3 class="mb-0 fw-bold">Konfirmasi Pemesanan</h3>
    </div>

    <div class="booking-wrapper">
        <div class="row g-4">

            {{-- KIRI --}}
            <div class="col-lg-8">
                <div class="box-card">

                    <p class="text-muted mb-4">
                        Periksa kembali detail pemesanan Anda sebelum melanjutkan ke pembayaran.
                    </p>

                    {{-- DATA PEMESAN --}}
                    <h5 class="fw-bold mb-3">Data Pemesan</h5>

                    <div class="border rounded-4 p-4 mb-4">

                        <div class="row mb-3">
                            <div class="col-md-4 text-muted">Nama Lengkap</div>
                            <div class="col-md-4 fw-semibold">{{ request('nama') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 text-muted">Email</div>
                            <div class="col-md-4 fw-semibold">{{ request('email') }}</div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 text-muted">No. Handphone</div>
                            <div class="col-md-4 fw-semibold">{{ request('phone') }}</div>
                        </div>

                    </div>

                    {{-- DATA TAMU --}}
                    <h5 class="fw-bold mb-3">Data Tamu</h5>

                    <div class="border rounded-4 p-4 mb-4">

                        <div class="row mb-3">
                            <div class="col-md-4 text-muted">Nama Tamu</div>
                            <div class="col-md-4 fw-semibold">{{ request('guest_name') }}</div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 text-muted">Permintaan Khusus</div>
                            <div class="col-md-4 fw-semibold">
                                {{ request('special_request') ?: '-' }}
                            </div>
                        </div>

                    </div>

                    {{-- MIDTRANS BUTTON --}}
                    <h5 class="fw-bold mb-3">Pembayaran</h5>

                    <button id="pay-button" class="btn btn-primary w-100 py-3">
                        Bayar Sekarang
                    </button>

                </div>
            </div>

            {{-- RINGKASAN --}}
            <div class="col-lg-4">
                <div class="box-card">

                    <h5 class="fw-bold mb-3">Ringkasan Pemesanan</h5>

                    <div class="room-summary d-flex gap-3 mb-4">

                        <img src="{{ asset('images/'.$variant->image) }}">

                        <div>
                            <h6 class="fw-bold">{{ $variant->name }}</h6>

                            <span class="text-primary fw-semibold">
                                Rp {{ number_format($variant->price,0,',','.') }} / malam
                            </span>
                        </div>

                    </div>

                    <div class="summary-list">

                        <div>
                            <span>Check-in</span>
                            <strong>{{ $checkin }}</strong>
                        </div>

                        <div>
                            <span>Check-out</span>
                            <strong>{{ $checkout }}</strong>
                        </div>

                        <div>
                            <span>Tamu</span>
                            <strong>{{ $adult }} Dewasa, {{ $child }} Anak</strong>
                        </div>

                        <div>
                            <span>Durasi</span>
                            <strong>{{ $duration }} Malam</strong>
                        </div>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span>Total Harga</span>
                        <strong class="text-primary fs-4">
                            Rp {{ number_format($totalPrice,0,',','.') }}
                        </strong>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

{{-- MIDTRANS SNAP --}}
<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.clientKey') }}">
</script>

<script>
    document.getElementById('pay-button').onclick = function () {
        snap.pay(@json($snapToken), {
            onSuccess: function (result) {
                window.location.href = "/payment/success";
            },

            onPending: function (result) {
                window.location.href = "/payment/pending";
            },

            onError: function (result) {
                alert("Pembayaran gagal!");
            },

            onClose: function () {
                console.log("Popup ditutup");
            }
        });

    };
</script>
@endsection