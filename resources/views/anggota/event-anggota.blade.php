@extends('layout.event-anggota')
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
                <h1 class="fw-bold text-black">Transformasi APJI Dimulai Di Sini</h1>
                <p class="text-dark">Tingkatkan Pengetahuan, Kembangkan Bisnis, dan Bangun Kolaborasi Dengan Para Pelaku Industri</p>
            </div>

             <!-- Search Section -->
             <div class="container pt-4">
                <form class="d-flex" role="search" method="GET" action="{{ route('event') }}">
                    <input class="form-control me-2" type="search" name="search" value="{{ request('search') }}" placeholder="Cari Event" aria-label="Search">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </form>
            </div>

            <!-- Event Section-->
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
                                <a href="#" class="btn btn-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#eventDetailModal{{ $item->id }}-{{ $loop->index }}">Detail Event</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- MODAL DETAIL EVENT for each item in the loop -->
                    <div class="modal fade" id="eventDetailModal{{ $item->id }}-{{ $loop->index }}" tabindex="-1" 
                        aria-labelledby="eventDetailModalLabel{{ $item->id }}-{{ $loop->index }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eventDetailModalLabel{{ $item->id }}-{{ $loop->index }}">Detail Event</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <!-- Event Image -->
                                    <div class="text-center mb-4">
                                        <img 
                                            src="{{ asset($item->img) }}" 
                                            alt="Event {{ $item->nama_event }}" 
                                            class="img-fluid rounded" 
                                            style="max-height: 300px; object-fit: cover;">
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
                                    {{-- <button type="button" class="btn btn-success" data-bs-dismiss="modal">Daftar</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    @if ($event->isEmpty())
                    <p class="text-center text-muted">Belum ada event tersedia.</p>
                    @endif
                </div>
            </div>
        
            <div class="container pt-4">
                @if ($event->total() >= 6)
                    <div class="d-flex justify-content-start"> <!-- Posisi pagination di pojok kiri -->
                        {{ $event->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection