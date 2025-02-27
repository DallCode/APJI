@extends('layout.riwayat-event')
@section('content')

<!-- Container -->
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <x-sidebar-user/>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <!-- Header Section -->
            <div class="header-section text-center py-4 bg-gradient">
                <h1 class="fw-bold text-black">Riwayat Event</h1>
                <p class="text-dark">Lihat kembali event-event APJI yang telah terlewatkan sebelumnya.</p>
            </div>

             <!-- Search Section -->
             <div class="container pt-4">
                <form class="d-flex" role="search" method="GET" action="{{ route('riwayat') }}">
                    <input class="form-control me-2" type="search" name="search" value="{{ request('search') }}" placeholder="Cari Riwayat Event" aria-label="Search">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </form>
            </div>

            <!-- Riwayat Events Section -->
            <div class="container pt-4">
                <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
                    @foreach ($event as $item)
                    <div class="col d-flex align-items-stretch">
                        <div class="card shadow-sm border-0 rounded event-card" style="width:290px">
                            <img src="{{ asset($item->img) }}" alt="{{ $item->nama_event }}" class="card-img-top rounded-top" style="object-fit: cover; height: 180px;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-center fw-bold text-dark mb-2" style="font-size: 17px;">{{ $item->nama_event }}</h5>
                                <p class="card-text text-muted mb-1" style="font-size: 14px;"><i class="bx bx-calendar me-2 text-primary"></i>{{ $item->tanggal }}</p>
                                <p class="card-text text-muted" style="font-size: 14px;"><i class="bx bx-map me-2 text-danger"></i>{{ $item->lokasi }}</p>
                                <button class="btn btn-primary w-100 mt-auto" data-bs-toggle="modal" data-bs-target="#eventDetailModal{{ $item->id }}">Detail Event</button>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if ($event->isEmpty())
                    <p class="text-center text-muted">Belum ada event tersedia.</p>
                    @endif
                </div>
            </div>

            <!-- Pagination Section -->
            <div class="container pt-4">
                @if ($event->total() > 6)
                    <div class="d-flex justify-content-end"> <!-- Posisi pagination di pojok kanan bawah -->
                        {{ $event->links() }}
                    </div>
                @endif
            </div>

            <!-- Modals -->
            @foreach ($event as $item)
            <div class="modal fade" id="eventDetailModal{{ $item->id }}" tabindex="-1" aria-labelledby="eventDetailModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="eventDetailModalLabel{{ $item->id }}">Detail Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <!-- Event Image -->
                            <div class="text-center mb-4">
                                <img src="{{ asset($item->img) }}" alt="Event {{ $item->nama_event }}" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
                            </div>
                            <!-- Event Details -->
                            <h5 class="text-center fw-bold mb-3">{{ $item->nama_event }}</h5>
                            <p class="text-muted mb-3">{{ $item->deskripsi }}</p>
                            <p class="text-muted mb-1">
                                <i class="bx bx-calendar me-2 text-primary"></i>{{ $item->tanggal }}
                            </p>
                            <p class="text-muted">
                                <i class="bx bx-map me-2 text-danger"></i>{{ $item->lokasi }}
                            </p>
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Daftar</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        </main>
    </div>
        <!-- Footer -->
    {{-- @include('components.footer-user') --}}
</div>
@endsection
