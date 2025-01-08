@extends('layout.event')
@section('content')
<div class="container-fluid">
    <div class="row">

        <x-sidebar-admin/>

        <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <h1>Event</h1>

            <div class="category">
                <a class="add-new" href="" data-bs-toggle="modal" data-bs-target="#createEventModal">Add
                    New</a>

                <form class="search" action="" method="GET">
                    <input type="text" name="search" placeholder="Cari event" value="">
                    <button type="submit"><i class='bx bx-search-alt-2'></i>Cari</button>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event as $event)
                            <tr>
                                <td>{{ $event->nama_event }}</td>
                                <td><a class="detail" href="">Lihat Detail</a></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateModal"
                                            data-id-event="{{ $event->id_event }}"
                                            data-nama-event="{{ $event->nama_event }}"
                                            data-tanggal="{{ $event->tanggal }}" data-lokasi="{{ $event->lokasi }}"
                                            data-daftar-hadir="{{ $event->daftar_hadir }}"
                                            data-notulensi="{{ $event->notulensi }}"
                                            data-dokumentasi="{{ $event->dokumentasi }}">
                                            <i class='bx bxs-pencil'></i>
                                        </a>
                                        <form method="POST" action="{{ route('event.delete', $event->id_event) }}"
                                            style="display: inline-block; margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-button">
                                                <i class='bx bxs-trash'></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">

                </div>
            </div>

        </main>
    </div>
</div>

<!-- Modal for Creating Event -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEventModalLabel">Create New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('event.store') }}" method="POST">
                @csrf <!-- Tambahkan CSRF Token -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_event" class="form-label">Nama Event</label>
                        <input type="text" class="form-control" id="nama_event" name="nama_event"
                            placeholder="Masukkan nama event" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi"
                            placeholder="Masukkan lokasi event" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Update -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('event.update', $event->id_event) }}"
                enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_event">Nama Event</label>
                        <input type="text" class="form-control" id="nama_event" name="nama_event"
                            value="{{ $event->nama_event }}">
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                            value="{{ $event->tanggal }}">
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi"
                            value="{{ $event->lokasi }}">
                    </div>
                    <div class="form-group">
                        <label for="daftar_hadir">Daftar Hadir</label>
                        <textarea class="form-control" id="daftar_hadir" name="daftar_hadir">{{ $event->daftar_hadir }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="notulensi">Notulensi</label>
                        <textarea class="form-control" id="notulensi" name="notulensi">{{ $event->notulensi }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="dokumentasi">Dokumentasi</label>
                        <input type="file" class="form-control" id="dokumentasi" name="dokumentasi">
                        @if ($event->dokumentasi)
                            <img src="data:image/jpeg;base64,{{ $event->dokumentasi }}" alt="Gambar Dokumentasi"
                                width="100px">
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-top:10px">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function(event) {
            if (!confirm('Apakah Anda yakin ingin menghapus event ini?')) {
                event.preventDefault();
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var updateModal = document.getElementById('updateModal');
        updateModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Tombol yang diklik
            var idEvent = button.getAttribute('data-id-event');
            var namaEvent = button.getAttribute('data-nama-event');
            var tanggal = button.getAttribute('data-tanggal');
            var lokasi = button.getAttribute('data-lokasi');
            var daftarHadir = button.getAttribute('data-daftar-hadir');
            var notulensi = button.getAttribute('data-notulensi');
            var dokumentasi = button.getAttribute('data-dokumentasi');

            // Isi nilai dalam form modal
            var modal = updateModal;
            modal.querySelector('#nama_event').value = namaEvent;
            modal.querySelector('#tanggal').value = tanggal;
            modal.querySelector('#lokasi').value = lokasi;
            modal.querySelector('#daftar_hadir').value = daftarHadir || '';
            modal.querySelector('#notulensi').value = notulensi || '';

            if (dokumentasi) {
                var imgPreview = modal.querySelector('img');
                if (imgPreview) {
                    imgPreview.src = 'data:image/jpeg;base64,' + dokumentasi;
                    imgPreview.style.display = 'block';
                }
            }

            // Update action form untuk ID event yang sesuai
            var form = modal.querySelector('form');
            form.action = '/event/update/' + idEvent;
        });
    });
</script>
@endsection