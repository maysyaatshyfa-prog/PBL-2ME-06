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
                        <th class="py-3">Status Reservasi</th>
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

                                    <small class="text-muted">
                                        Kamar {{ optional($item->roomNumber)->room_number }}
                                    </small>

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

                            @if($item->status == 'Selesai')

                            <span class="badge bg-success px-3 py-2 rounded-pill">
                                Selesai
                            </span>

                            @elseif($item->status == 'Batal')

                            <span class="badge bg-danger px-3 py-2 rounded-pill">
                                Batal
                            </span>

                            @else

                            <span class="badge bg-primary px-3 py-2 rounded-pill">
                                Dalam Proses
                            </span>

                            @endif

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

                                @if($item->status_pembayaran != 'Lunas')
                                <a href="{{ route('payment.pay', $item->id) }}"
                                    class="btn btn-success btn-sm rounded-pill px-3">
                                    Bayar
                                </a>
                                @endif

                                @if($item->cancellation)

                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                    Menunggu Persetujuan
                                </span>

                                @elseif($item->status != 'Selesai' && $item->status != 'Batal')

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

                <div class="modal-header">

                    <h5 class="modal-title">
                        Ajukan Pembatalan Reservasi
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <label class="form-label">
                        Alasan Pembatalan
                    </label>

                    <textarea name="reason" class="form-control" rows="4" required
                        placeholder="Masukkan alasan pembatalan reservasi"></textarea>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>

                    <button type="submit" class="btn btn-danger">
                        Kirim Permohonan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endif

@endforeach
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif
@endsection
