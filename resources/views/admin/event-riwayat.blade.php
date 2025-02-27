@extends('layout.event')
@section('content')

<div class="container-fluid">
    <div class="row">

        <x-sidebar-admin/>

        <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <h1>RiwayatEvent</h1>

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
                            {{-- <th></th> --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event as $event)
                            <tr>
                                <td>{{ $event->nama_event }}</td>
                                {{-- <td><a class="detail" href="">Lihat Detail</a></td> --}}
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

<script>
    function previewImage() {
        const input = document.getElementById('img');
        const preview = document.getElementById('imgPreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>

@endsection