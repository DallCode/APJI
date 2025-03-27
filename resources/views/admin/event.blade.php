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
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event as $item)
                            @php
                            // Event is expired only when it has passed by at least one day
                            $today = \Carbon\Carbon::now();
                            $eventDate = \Carbon\Carbon::parse($item->tanggal);
                            $expired = $eventDate->addDay()->isPast();
                            @endphp
                            <tr class="{{ $expired ? 'text-danger' : '' }}">
                                <td>{{ $item->nama_event }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateModal"
                                            data-id-event="{{ $item->id_event }}"
                                            data-nama-event="{{ $item->nama_event }}"
                                            data-tanggal="{{ $item->tanggal }}" 
                                            data-lokasi="{{ $item->lokasi }}"
                                            data-daftar-hadir="{{ $item->daftar_hadir }}"
                                            data-notulensi="{{ $item->notulensi }}"
                                            data-dokumentasi="{{ $item->dokumentasi }}">
                                            <i class='bx bxs-pencil'></i>
                                        </a>
                                        <form method="POST" action="{{ route('event.delete', $item->id_event) }}"
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

                <div class="container pt-4">
                    @if ($event->total() > 6)
                        <div class="d-flex justify-content-right">
                            <nav>
                                <ul class="pagination">
                                    {{-- Tombol Previous --}}
                                    @if ($event->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $event->previousPageUrl() }}">Previous</a>
                                        </li>
                                    @endif

                                    {{-- Nomor Halaman --}}
                                    @foreach ($event->getUrlRange(1, $event->lastPage()) as $page => $url)
                                        <li class="page-item {{ $event->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Tombol Next --}}
                                    @if ($event->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $event->nextPageUrl() }}">Next</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">Next</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal for Creating Event -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEventModalLabel">Create New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_event" class="form-label">Nama Event</label>
                        <input type="text" class="form-control" id="nama_event" name="nama_event" placeholder="Masukkan nama event" required>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Poster</label>
                        <input type="file" class="form-control" id="img" name="img" accept="image/*" required onchange="previewImage()">
                        <img id="imgPreview" src="#" alt="Preview" style="margin-top: 10px; max-width: 100%; height: auto; display: none;">
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan Deskripsi Event" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Masukkan lokasi event" required>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="nama_event">Nama Event</label>
                        <input type="text" class="form-control" id="nama_event" name="nama_event">
                    </div>
                    <div class="form-group mb-3">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                    </div>
                    <div class="form-group mb-3">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi">
                    </div>
                    <div class="form-group mb-3">
                        <label for="notulensi">Notulensi</label>
                        <textarea class="form-control" id="notulensi" name="notulensi"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="dokumentasi">Dokumentasi</label>
                        <textarea class="form-control" id="dokumentasi" name="dokumentasi"></textarea>
                    </div>
                    {{-- <div class="form-group mb-3">
                        <label for="dokumentasi">Dokumentasi</label>
                        <input type="file" class="form-control" id="dokumentasi" name="dokumentasi">
                        <img src="#" alt="Gambar Dokumentasi" width="100px" style="margin-top: 10px; display: none;">
                    </div> --}}
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
            
            if (modal.querySelector('#daftar_hadir')) {
                modal.querySelector('#daftar_hadir').value = daftarHadir || '';
            }
            
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.querySelector("table");
        const headers = table.querySelectorAll("th");
        const tbody = table.querySelector("tbody");

        const sortTable = (index, asc) => {
            const rows = Array.from(tbody.querySelectorAll("tr"));
            
            rows.sort((rowA, rowB) => {
                const cellA = rowA.children[index].textContent.trim().toLowerCase();
                const cellB = rowB.children[index].textContent.trim().toLowerCase();
                
                if (!isNaN(Date.parse(cellA)) && !isNaN(Date.parse(cellB))) {
                    return asc ? new Date(cellA) - new Date(cellB) : new Date(cellB) - new Date(cellA);
                }
                
                return asc ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
            });
            
            rows.forEach(row => tbody.appendChild(row));
        };

        headers.forEach((header, index) => {
            let asc = true;
            header.addEventListener("click", () => {
                sortTable(index, asc);
                asc = !asc;
            });
        });
    });
</script>


@endsection