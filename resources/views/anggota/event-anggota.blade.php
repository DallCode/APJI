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
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Cari Event" aria-label="Search">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </form>
            </div>

            <!-- Events Section -->
            <div class="simple-container pt-1">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @forelse ($event as $event)
                    <div class="col">
                        <div class="card-a shadow-sm border-0 rounded event-card">
                            <img src="https://via.placeholder.com/300" alt="Event {{ $event->nama_event }}" class="event-card-img rounded-top" style="object-fit: cover; width: 100%; height: 120px;">
                            <div class="card-body p-2">
                            <h5 class="card-title text-center fw-bold text-dark mb-3" style="font-size: 17px;">{{ $event->nama_event }}</h5>
                                <p class="card-text text-muted mb-1" style="font-size: 14px;">
                                    <i class="bx bx-calendar me-2 text-primary"></i>{{ $event->tanggal }}
                                </p>
                                <p class="card-text text-muted" style="font-size: 14px;">
                                    <i class="bx bx-map me-2 text-danger"></i>{{ $event->lokasi }}
                                </p>
                                <a href="#" class="btn btn-primary w-100 mt-3">Detail Event</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-muted">Belum ada event tersedia.</p>
                    @endforelse
                </div>
            </div>
            
            {{-- <div class="simple-container pt-5">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @forelse ($event as $event)
                    <div class="col">
                        <div class="card-a shadow-sm border-0 rounded event-card">
                            <img src="https://via.placeholder.com/300" alt="Event {{ $event->nama_event }}" class="event-card-img rounded-top"  style="object-fit: cover; width: 100%; height: 120px;">
                            <div class="card-body p-2">
                                <h5 class="card-title text-center fw-bold text-dark mb-3" style="font-size: 14px">{{ $event->nama_event }}</h5>
                                <p class="card-text text-muted" style="font-size: 14px">
                                    <i class="bx bx-calendar me-2 text-primary"></i>{{ $event->tanggal }}</p>
                                <p class="card-text text-muted mb-3" style="font-size: 14px">
                                    <i class="bx bx-map me-2 text-danger"></i>{{ $event->lokasi }}</p>
                                <a href="#" class="btn btn-primary w-100 mt-3">Detail Event</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-muted">Belum ada event tersedia.</p>
                    @endforelse
                </div>
            </div> --}}
        </main>
        <!-- Footer -->
    {{-- @include('components.footer-user') --}}
    </div>
</div>
@endsection  
