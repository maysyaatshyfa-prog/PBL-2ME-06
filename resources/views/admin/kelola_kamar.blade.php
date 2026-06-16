@extends('layouts.app')

@section('title', 'Kelola Kamar')

@section('content')
@push('scripts')
@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function () {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: @json(session('success')),
            timer: 2000,
            showConfirmButton: false
        });
    });
</script>
@endif
@endpush
<div class="layout d-flex">

    {{-- SIDEBAR --}}
    @include('components.sidebar')

    {{-- MAIN CONTENT --}}
    <div class="main flex-grow-1 p-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Kelola Kamar</h4>
        </div>

        {{-- POPUP DAFTAR KAMAR --}}
        <div id="room-detail-card" class="room-overlay d-none">

            <div class="room-modal">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h4 id="room-title" class="mb-0">
                        Detail Kamar
                    </h4>

                    <button type="button" class="btn-close" onclick="closeRooms()">
                    </button>

                </div>

                <div class="mb-3">
                    <span class="badge bg-success">Tersedia</span>
                    <span class="badge bg-secondary">Terisi</span>
                    <span class="badge bg-dark">Maintenance</span>
                </div>

                <div id="room-grid" class="room-grid">
                </div>

            </div>

        </div>

        {{-- TABEL --}}
        <div class="card shadow-sm rounded-3">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover text-center align-middle">

                        <thead class="text-muted small">
                            <tr>
                                <th>No</th>
                                <th>Tipe Kamar</th>
                                <th>Sub Tipe</th>
                                <th>Harga</th>
                                <th>Kapasitas</th>
                                <th>Jumlah Kamar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($rooms as $i => $room)

                            <tr>

                                <td>{{ $i + 1 }}</td>

                                <td>
                                    {{ $room->room->title ?? '-' }}
                                </td>

                                <td>
                                    {{ $room->name }}
                                </td>

                                <td>
                                    Rp {{ number_format($room->price, 0, ',', '.') }}
                                </td>

                                <td>
                                    {{ $room->capacity }} Orang
                                </td>

                                <td>
                                     {{ $room->room_numbers_count ?? 0 }}
                                </td>

                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- Daftar Kamar --}}
                                        <button type="button" class="btn btn-outline-secondary btn-action"
                                            title="Daftar Kamar" onclick='showRooms(
        "{{ $room->name }}",
        @json($room->roomNumbers)
    )'>

                                            <i class="bi bi-door-open"></i>

                                        </button>

                                        {{-- Edit --}}
                                        <button type="button" class="btn btn-outline-primary" onclick='openEditModal(
        {{ $room->id }},
        @json($room->name),
        {{ $room->price }},
        {{ $room->capacity }},
        @json($room->size),
        @json($room->bed_type),
        @json($room->room_view),
        @json($room->facilities),
        "{{ asset('images/'.$room->image) }}",
        @json($room->gallery)
    )'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        {{-- Hapus --}}
                                        <button class="btn btn-outline-danger btn-action" title="Hapus">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </div>

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="7" class="py-5 text-muted">
                                    Belum ada data kamar
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>
{{-- MODAL EDIT KAMAR --}}
<div class="modal fade" id="editRoomModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="editRoomForm" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">
                        Edit Kamar
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Nama Varian</label>
                            <input type="text" name="name" id="edit_name" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Harga</label>
                            <input type="number" name="price" id="edit_price" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Kapasitas</label>
                            <input type="number" name="capacity" id="edit_capacity" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Ukuran Kamar</label>
                            <input type="text" name="size" id="edit_size" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tipe Kasur</label>
                            <input type="text" name="bed_type" id="edit_bed_type" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>View Kamar</label>
                            <input type="text" name="room_view" id="edit_room_view" class="form-control">
                        </div>

                        <div class="col-12 mb-3">
                            <label>Fasilitas</label>
                            <textarea name="facilities" id="edit_facilities" rows="4" class="form-control"></textarea>
                        </div>

                        <div class="col-12">

                            <label class="form-label fw-bold">
                                Gambar Utama
                            </label>

                            <div class="image-card">

                                <div class="main-image-wrapper">
                                    <img id="preview_image" class="main-room-image">
                                </div>

                                <div class="mt-3">
                                    <label class="upload-box">
                                        <i class="bi bi-cloud-arrow-up"></i>

                                        <span>Upload Gambar Utama</span>

                                        <small>PNG, JPG, JPEG</small>

                                        <div id="imageFileName" class="selected-file">
                                            Belum ada file dipilih
                                        </div>

                                        <input type="file" name="image" id="imageInput" hidden>
                                    </label>

                                </div>

                            </div>

                        </div>

                        <div class="col-12">

                            <label class="form-label fw-bold">
                                Gallery Kamar
                            </label>

                            <div id="gallery_preview" class="gallery-grid"></div>

                            <div class="mt-3">


                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
<script>
    function showRooms(name, rooms) {
        document
            .getElementById('room-detail-card')
            .classList.remove('d-none');

        document
            .getElementById('room-title')
            .innerHTML = name;

        let html = '';

        rooms.forEach(room => {

            let statusClass = '';

            if (room.status === 'tersedia') {
                statusClass = 'available';
            } else if (room.status === 'terisi') {
                statusClass = 'occupied';
            } else {
                statusClass = 'maintenance';
            }

            html += `
            <div class="room-box ${statusClass}">
                ${room.room_number}
            </div>
            `;
        });

        document
            .getElementById('room-grid')
            .innerHTML = html;
    }

    function closeRooms() {
        document
            .getElementById('room-detail-card')
            .classList.add('d-none');
    }

    function openEditModal(
        id,
        name,
        price,
        capacity,
        size,
        bed_type,
        room_view,
        facilities,
        image,
        gallery
    ) {

        document.getElementById('edit_name').value = name;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_capacity').value = capacity;
        document.getElementById('edit_size').value = size;
        document.getElementById('edit_bed_type').value = bed_type;
        document.getElementById('edit_room_view').value = room_view;
        document.getElementById('edit_facilities').value = facilities;

        document.getElementById('preview_image').src = image;

        let preview = document.getElementById('gallery_preview');
        preview.innerHTML = '';

        try {

            let images = JSON.parse(gallery);

            images.forEach((img, index) => {
                preview.innerHTML += `
        <div class="gallery-item">

            <img src="/images/${img}" class="gallery-img">

            <input type="hidden"
                   name="old_gallery[]"
                   value="${img}">

            <input type="file"
                   name="replace_gallery[${index}]"
                   class="form-control mt-2">

        </div>
    `;
            });

        } catch (e) {
            console.log('Gallery error:', e);
        }

        document.getElementById('editRoomForm').action =
            `/admin/kelola-kamar/${id}`;

        new bootstrap.Modal(
            document.getElementById('editRoomModal')
        ).show();
    }
    document.getElementById('imageInput')
        .addEventListener('change', function () {

            document.getElementById('imageFileName')
                .innerText = this.files.length ?
                this.files[0].name :
                'Belum ada file dipilih';
        });
</script>

@endsection
