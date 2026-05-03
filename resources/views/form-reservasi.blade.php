@extends('layouts.app')

@section('content')
{{-- Navbar --}}
@include('components.navbar')

<div class="container py-5">

    {{-- Judul --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <div class="step-number">3</div>
        <h3 class="mb-0 fw-bold">Data Tamu </h3>
    </div>

    <div class="booking-wrapper">

        {{-- Content --}}
        <div class="row g-4">

            {{-- Form --}}
            <div class="col-lg-8">
                <div class="box-card">

                    <form action="{{ route('booking.confirm') }}" method="POST">
                        @csrf

                        <input type="hidden" name="check_in" value="{{ $checkin }}">
                        <input type="hidden" name="check_out" value="{{ $checkout }}">
                        <input type="hidden" name="room_variant_id" value="{{ $variant->id }}">
                        <input type="hidden" name="adult" value="{{ $adult }}">
                        <input type="hidden" name="child" value="{{ $child }}">

                        <h5 class="fw-bold mb-3">Informasi Pemesan</h5>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap *</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" placeholder="nama@email.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. Handphone *</label>
                            <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx">
                        </div>

                        <h5 class="fw-bold mt-4 mb-3">Informasi Tamu yang Menginap</h5>

                        <div class="mb-3">
                            <label class="form-label">Nama Tamu yang Menginap *</label>
                            <input type="text" name="guest_name" class="form-control" placeholder="Masukkan nama tamu">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Permintaan Khusus</label>
                            <textarea class="form-control" rows="4"
                                placeholder="Contoh: late check-in, kamar lantai atas"></textarea>
                        </div>

                        <div class="d-flex gap-3">
                            <a href="/konfirmasi" class="btn btn-outline-secondary w-50">Kembali</a>
                            <button type="submit" class="btn btn-primary-custom w-50">
                                Lanjut ke Konfirmasi
                            </button>
                        </div>

                    </form>

                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="col-lg-4">
                <div class="box-card">

                    <h5 class="fw-bold mb-3">Ringkasan Pemesanan</h5>

                    <div class="room-summary d-flex gap-3 mb-4">

                        {{-- Gambar kamar --}}
                        <img src="{{ asset('images/'.$variant->image) }}">
                        <div>
                            {{-- Nama kamar --}}
                            <h6 class="mb-1 fw-bold">{{ $variant->name }}</h6>

                            {{-- Harga --}}
                            <span class="text-primary fw-semibold">
                                Rp {{ number_format($variant->price,0,',','.') }} / malam
                            </span>
                        </div>
                    </div>

                    @php
                    $checkinDate = \Carbon\Carbon::parse($checkin);
                    $checkoutDate = \Carbon\Carbon::parse($checkout);
                    $durasi = $checkinDate->diffInDays($checkoutDate);
                    $total = $durasi * $variant->price;
                    @endphp

                    <div class="summary-list">

                        <div>
                            <span>Check-in</span>
                            <strong>{{ $checkinDate->format('d M Y') }}</strong>
                        </div>

                        <div>
                            <span>Check-out</span>
                            <strong>{{ $checkoutDate->format('d M Y') }}</strong>
                        </div>

                        <div>
                            <span>Tamu</span>
                            <strong>{{ $adult }} Dewasa, {{ $child }} Anak</strong>
                        </div>

                        <div>
                            <span>Durasi</span>
                            <strong>{{ $durasi }} Malam</strong>
                        </div>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Harga</span>

                        <strong class="text-primary fs-5">
                            Rp {{ number_format($total,0,',','.') }}
                        </strong>
                    </div>

                    <small class="text-muted">
                        Harga sudah termasuk pajak dan biaya layanan
                    </small>

                </div>
            </div>

        </div>
    </div>

    @endsection