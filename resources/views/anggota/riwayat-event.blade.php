@extends('layout.riwayat-event')
@section('content')

@if (session('success'))
<div style="color: green;">
    {{ session('success') }}
</div>
@endif

<!-- Container -->
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <x-sidebar-user/>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <!-- Header Section -->
            <div class="header-section text-center py-4 bg-gradient">
                <h1 class="fw-bold text-black">Riwayat Event Anda</h1>
                <p class="text-dark">Lihat kembali event-event yang telah Anda ikuti atau lewatkan sebelumnya.</p>
            </div>

            <!-- Search Section -->
            <div class="container pt-4">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Cari Riwayat Event" aria-label="Search">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </form>
            </div>

            <!-- Riwayat Events Section -->
            <div class="simple-container pt-1">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <!-- Event Card 1 -->
                    <div class="col">
                        <div class="event-card-simple shadow-sm rounded">
                            <img src="https://via.placeholder.com/300" alt="Event 1" class="event-card-img">
                            <div class="event-card-body">
                                <h5 class="event-card-title">Seminar Bisnis Kuliner Indonesia</h5>
                                <p class="event-card-description">Bergabunglah dengan para ahli di industri kuliner untuk mempelajari strategi terbaru dalam mengelola bisnis makanan.</p>
                                <ul class="event-card-details">
                                    <li>15 Januari 2024</li>
                                    <li>09:00 - 12:00</li>
                                    <li>Jakarta, Indonesia</li>
                                    <li class="text-success">Selesai</li>
                                </ul>
                                <div class="event-card-completed-time text-center mt-3">
                                    <span class="badge bg-primary text-white py-2 px-3">
                                        <i class="bi bi-calendar-check"></i> Diselesaikan pada: <strong>15 Januari 2024</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Event Card 2 -->
                    <div class="col">
                        <div class="event-card-simple shadow-sm rounded">
                            <img src="https://via.placeholder.com/300" alt="Event 2" class="event-card-img">
                            <div class="event-card-body">
                                <h5 class="event-card-title">Workshop Pemasaran Digital</h5>
                                <p class="event-card-description">Pelajari bagaimana menggunakan pemasaran digital untuk meningkatkan visibilitas dan penjualan bisnis restoran Anda.</p>
                                <ul class="event-card-details">
                                    <li>18 Januari 2024</li>
                                    <li>13:00 - 16:00</li>
                                    <li>Bandung, Indonesia</li>
                                    <li class="text-success">Selesai</li>
                                </ul>
                                <div class="event-card-completed-time text-center mt-3">
                                    <span class="badge bg-primary text-white py-2 px-3">
                                        <i class="bi bi-calendar-check"></i> Diselesaikan pada: <strong>17 Januari 2024</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Event Card 3 -->
                    <div class="col">
                        <div class="event-card-simple shadow-sm rounded">
                            <img src="https://via.placeholder.com/300" alt="Event 3" class="event-card-img">
                            <div class="event-card-body">
                                <h5 class="event-card-title">Webinar Tren Industri Jasa Boga</h5>
                                <p class="event-card-description">Pelajari tren terbaru dalam industri jasa boga dan bagaimana mengadaptasi bisnis Anda untuk masa depan.</p>
                                <ul class="event-card-details">
                                    <li>25 Januari 2024</li>
                                    <li>10:00 - 11:30</li>
                                    <li>Online</li>
                                    <li class="text-success">Selesai</li>
                                </ul>
                                <div class="event-card-completed-time text-center mt-3">
                                    <span class="badge bg-primary text-white py-2 px-3">
                                        <i class="bi bi-calendar-check"></i> Diselesaikan pada: <strong>25 Januari 2024</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
        <!-- Footer -->
    {{-- @include('components.footer-user') --}}
</div>
@endsection
