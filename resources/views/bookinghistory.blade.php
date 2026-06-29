@extends('layouts.app')

@section('title', 'History Booking')

@section('content')

@include('components.navbar')

<div class="container-fluid px-3 px-md-5">
    <h2 class="title my-4">HISTORY RESERVASI</h2>

    <div class="card-box shadow-sm rounded-4 p-4 bg-white">

        <div class="table-responsive">

            <table class="table table-hover align-middle text-center">

                <thead>
                    <tr class="table-dark">
                        <th class="py-3">No</th>
                        <th class="py-3">Tipe Kamar</th>
                        <th class="py-3">Check-in</th>
                        <th class="py-3">Check-out</th>
                        <th class="py-3">Status Pembayaran</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($bookings as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td class="text-start">

                            <div class="d-flex align-items-center py-2">

                                <img src="{{ optional(optional($item->roomNumber)->variant)->image
                                    ? asset('images/' . $item->roomNumber->variant->image)
                                    : asset('img/kamar.jpg') }}" class="rounded-3 shadow-sm me-3"
                                    style="width:110px;height:75px;object-fit:cover;">

                                <div class="text-start">

                                    <div class="fw-semibold">
                                        {{ optional(optional($item->roomNumber)->variant)->name ?? 'Kamar Tidak Ditemukan' }}
                                    </div>


                                </div>

                            </div>

                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->check_in)->translatedFormat('d M Y') }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->check_out)->translatedFormat('d M Y') }}
                        </td>

                        <td>

                            @if($item->status_pembayaran == 'Lunas')

                            <span class="badge bg-success px-3 py-2 rounded-pill">
                                Lunas
                            </span>

                            @else

                            <span class="badge bg-danger px-3 py-2 rounded-pill">
                                Belum Bayar
                            </span>

                            @endif

                        </td>

                        <td>

                            <div class="d-flex justify-content-center gap-2 flex-wrap">

                                <a href="{{ route('booking.detail', $item->id) }}"
                                    class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                    Detail
                                </a>

                                @if($item->cancellation)

                                @php
                                $statusPembatalan = strtolower($item->cancellation->status);
                                @endphp

                                @if($statusPembatalan == 'menunggu')

                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                    Menunggu Persetujuan
                                </span>

                                @elseif($statusPembatalan == 'disetujui')

                                <span class="badge bg-danger px-3 py-2 rounded-pill">
                                    Reservasi Dibatalkan
                                </span>

                                @elseif($statusPembatalan == 'ditolak')

                                <button type="button" class="btn btn-danger btn-sm rounded-pill px-3"
                                    data-bs-toggle="modal" data-bs-target="#cancelModal{{ $item->id }}">
                                    Batalkan
                                </button>

                                <span class="badge bg-secondary px-3 py-2 rounded-pill">
                                    Pembatalan Ditolak
                                </span>

                                @endif

                                @else

                                <button type="button" class="btn btn-danger btn-sm rounded-pill px-3"
                                    data-bs-toggle="modal" data-bs-target="#cancelModal{{ $item->id }}">
                                    Batalkan
                                </button>

                                @endif

                            </div>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            Belum ada data reservasi yang tersedia.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- MODAL PEMBATALAN --}}
@foreach($bookings as $item)
@if($item->status != 'Selesai' && $item->status != 'Batal')

<div class="modal fade" id="cancelModal{{ $item->id }}" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{ route('cancellation.store') }}" method="POST">

                @csrf

                <input type="hidden" name="reservation_id" value="{{ $item->id }}">

                <div class="modal-body px-4">

                    <div class="text-center mb-4">
                        <div class="cancel-icon mx-auto mb-3">
                            <i class="bi bi-x-circle"></i>
                        </div>

                        <h5 class="fw-bold mb-2">
                            Batalkan Reservasi
                        </h5>

                        <p class="text-muted small mb-0">
                            Reservasi yang dibatalkan tidak dapat dipulihkan kembali.
                        </p>
                    </div>

                    <label class="fw-semibold mb-3">
                        Pilih alasan pembatalan
                    </label>

                    <div class="reason-list">

                        <label class="reason-card">
                            <input type="radio" name="reason" value="Perubahan rencana perjalanan" required>

                            <div class="d-flex align-items-center gap-3">
                                <i class="bi bi-calendar-event reason-icon"></i>
                                <span>Perubahan rencana perjalanan</span>
                            </div>
                        </label>

                        <label class="reason-card">
                            <input type="radio" name="reason" value="Menemukan hotel lain">

                            <div class="d-flex align-items-center gap-3">
                                <i class="bi bi-building reason-icon"></i>
                                <span>Menemukan hotel lain</span>
                            </div>
                        </label>

                        <label class="reason-card">
                            <input type="radio" name="reason" value="Masalah pembayaran">

                            <div class="d-flex align-items-center gap-3">
                                <i class="bi bi-credit-card reason-icon"></i>
                                <span>Masalah pembayaran</span>
                            </div>
                        </label>

                        <label class="reason-card">
                            <input type="radio" name="reason" value="Tidak jadi menginap">

                            <div class="d-flex align-items-center gap-3">
                                <i class="bi bi-door-closed reason-icon"></i>
                                <span>Tidak jadi menginap</span>
                            </div>
                        </label>

                        <label class="reason-card">
                            <input type="radio" name="reason" value="Lainnya">

                            <div class="d-flex align-items-center gap-3">
                                <i class="bi bi-three-dots reason-icon"></i>
                                <span>Lainnya</span>
                            </div>
                        </label>

                    </div>
                    <div class="mt-3 d-none lainnya-box">
                        <textarea class="form-control" name="other_reason" rows="3"
                            placeholder="Tuliskan alasan pembatalan...">
                        </textarea>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4">

                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                            Kembali
                        </button>

                        <button type="submit" class="btn btn-danger rounded-pill px-4">
                            Kirim Permohonan
                        </button>

                    </div>

                </div>
            </form>

        </div>

    </div>

</div>

@endif

@endforeach
<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.modal').forEach(modal => {

            const radios = modal.querySelectorAll('input[name="reason"]');
            const lainnyaBox = modal.querySelector('.lainnya-box');
            const textarea = lainnyaBox.querySelector('textarea');

            radios.forEach(radio => {

                radio.addEventListener('change', function () {

                    if (this.value === 'Lainnya') {

                        lainnyaBox.classList.remove('d-none');
                        textarea.setAttribute('required', true);

                    } else {

                        lainnyaBox.classList.add('d-none');
                        textarea.removeAttribute('required');
                        textarea.value = '';

                    }

                });

            });

        });

    });
</script>
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {

        Swal.fire({
            icon: 'success',
            title: 'Permohonan Terkirim',
            html: `
            Permohonan pembatalan reservasi telah berhasil dikirim.<br>
            Silakan tunggu persetujuan admin.
        `,
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#dc3545'
        });

    });
</script>
@endif
@endsection