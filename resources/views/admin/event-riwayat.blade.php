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
                                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#eventDetailModal{{ $item->id }}-{{ $loop->index }}">
                                        Detail Event
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal untuk Detail Event -->
                    <div class="modal fade" id="eventDetailModal{{ $item->id }}-{{ $loop->index }}" tabindex="-1" aria-labelledby="eventDetailModalLabel{{ $item->id }}-{{ $loop->index }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold" id="eventDetailModalLabel{{ $item->id }}-{{ $loop->index }}">Detail Event</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Event Image -->
                                    <div class="text-center mb-4">
                                        {{-- <img src="{{ asset($item->img) }}" alt="Event {{ $item->nama_event }}" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;"> --}}
                                    </div>
                                    <!-- Event Details -->
                                    <h5 class="text-center fw-bold mb-3">{{ $item->nama_event }}</h5>
        
                                    <p class="text-muted mb-3">
                                        <strong>Tanggal:</strong>
                                        {{ $item->tanggal }}</p>
                                    <!-- Notulensi -->
                                    <p class="text-muted mb-3">
                                        <strong>Notulensi:</strong> 
                                        {{ $item->notulensi ? $item->notulensi : 'Notulensi belum tersedia' }}
                                    </p>
        
                                    <!-- Dokumentasi -->
                                    <p class="text-muted mb-3">
                                        <strong>Dokumentasi:</strong> 
                                        @if ($item->dokumentasi)
                                            <a href="{{ $item->dokumentasi }}" target="_blank" class="text-primary">{{ $item->dokumentasi }}</a>
                                        @else
                                            Dokumentasi belum tersedia
                                        @endif
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                    
                    
                    @if ($event->isEmpty())
                    <div class="col-12">
                        <p class="text-center text-muted">Belum ada event tersedia.</p>
                    </div>
                    @endif
                </div>
                <!-- Pagination Section -->
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

@endsection
