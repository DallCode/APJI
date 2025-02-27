@extends('layout.event')
@section('content')

<div class="container-fluid">
    <div class="row">
        <x-sidebar-admin/>

        <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <div class="container pt-4">
                <h1>Riwayat Event</h1>

                <!-- Search Section -->
                <div class="container pt-4">
                    <form class="d-flex" role="search" method="GET" action="{{ route('admin.event-riwayat') }}">
                        <input class="form-control me-2" type="search" name="search" value="{{ request('search') }}" placeholder="Cari Event" aria-label="Search">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </form>
                </div>

                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach ($event as $item)
                    <div class="col">
                        <div class="card shadow-sm h-100">
                            <img src="{{ asset($item->img) }}" alt="{{ $item->nama_event }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-center fw-bold">{{ $item->nama_event }}</h5>

                                <div class="mt-3">
                                    <p class="card-text mb-2">
                                        <i class="bx bx-calendar text-primary me-2"></i>
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                    </p>
                                    <p class="card-text">
                                        <i class="bx bx-map text-danger me-2"></i>
                                        {{ $item->lokasi }}
                                    </p>
                                </div>

                                <div class="mt-auto">
                                    <a href="{{ route('detailEvent') }}" class="btn btn-primary w-100" data-bs-toggle="">
                                        Detail Event
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <!-- Modal for event details -->
                    <div class="modal fade" id="eventDetailModal{{ $item->id }}" tabindex="-1" 
                        aria-labelledby="eventDetailModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eventDetailModalLabel{{ $item->id }}">Detail Event</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center mb-4">
                                        <img 
                                            src="{{ asset($item->img) }}" 
                                            alt="Event {{ $item->nama_event }}" 
                                            class="img-fluid rounded" 
                                            style="max-height: 300px; object-fit: cover;">
                                    </div>
                                    <h5 class="text-center fw-bold mb-3">{{ $item->nama_event }}</h5>
                                    <p class="text-muted mb-3">{{ $item->deskripsi }}</p>
                                    <p class="text-muted mb-1">
                                        <i class="bx bx-calendar me-2 text-primary"></i>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                    </p>
                                    <p class="text-muted">
                                        <i class="bx bx-map me-2 text-danger"></i>{{ $item->lokasi }}
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    @endforeach

                    @if ($event->isEmpty())
                    <div class="col-12">
                        <p class="text-center text-muted">Belum ada event tersedia.</p>
                    </div>
                    @endif
                </div>

                <!-- Pagination Section -->
                {{-- <div class="d-flex justify-content-end mt-4">
                    @if ($event->hasPages())
                        {{ $event->links() }}
                    @endif
                </div> --}}
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