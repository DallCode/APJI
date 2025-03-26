@extends('layout.dashboard-anggota')
@section('content')
    <!-- Container -->
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar -->
            <x-sidebar-user />

       <!-- Main Content and Footer -->
       <main class="col-md-9 ms-sm-auto col-lg-10 content d-flex flex-column">
        <!-- Header Section -->
        <div class="header-section text-center py-4 bg-gradient">
            <h1 class="fw-bold text-black">Selamat Datang di Dashboard APJI</h1>
            <p class="text-dark">Asosiasi Pengusaha Jasa Boga Indonesia</p>
        </div>
    
        <!-- Statistics Section -->
        <section class="stats-section py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="d-flex gap-4 col-md-6 col-lg-5">
                        <!-- Pengajuan Sertifikat Card -->
                        <a href="{{ route('pengajuan') }}" class="text-decoration-none">
                            <div class="card border-0 shadow-lg rounded-4 p-3 d-flex align-items-center justify-content-center"
                                style="transition: transform 0.3s ease-in-out; height: 160px; width: 475px;">
                                <div class="text-center">
                                    <i class="bx bx-award text-primary"
                                        style="font-size: 4rem; margin-bottom: 8px;"></i>
                                    <h5 class="mt-0 fw-bold text-dark" style="font-size: 1.20rem;">Pengajuan
                                        Sertifikat</h5>
                                </div>
                            </div>
                        </a>

                        <!-- Kelayakan Usaha Card -->
                        <a href="{{ route('kelayakanUsaha') }}" class="text-decoration-none">
                            <div class="card border-0 shadow-lg rounded-4 p-3 d-flex align-items-center justify-content-center"
                                style="transition: transform 0.3s ease-in-out; height: 160px; width: 475px;">
                                <div class="text-center">
                                    <i class="bx bx-check-shield text-success"
                                        style="font-size: 4rem; margin-bottom: 8px;"></i>
                                    <h5 class="mt-0 fw-bold text-dark" style="font-size: 1.20rem;">Kelayakan Usaha
                                    </h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>



                <!-- Recent Activities Table -->
                <section class="recent-activities-section container py-4 mt-4">
                    <h3 class="fw-bold text-primary mb-3">Event Terbaru</h3>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle shadow-sm rounded-4 overflow-hidden">
                            <thead class="table-primary text-white">
                                <tr>
                                    <th>Event</th>
                                    <th>Tanggal</th>
                                    <th>Tempat</th>
                                    {{-- <th>Waktu</th> --}}
                                    <th class="text-center">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Event as $e)
                                    <tr>
                                        <td>{{ $e->nama_event }}</td> <!-- Nama event -->
                                        <td>{{ \Carbon\Carbon::parse($e->tanggal)->format('d F Y') }}</td>
                                        <!-- Format tanggal -->
                                        <td>{{ $e->lokasi }}</td> <!-- Tempat event -->
                                        {{-- <td>{{ $e->waktu }}</td> <!-- Waktu event --> --}}
                                        <td class="text-center">
                                            <a class="btn btn-outline-primary btn-sm shadow-sm" style="width: 110px"
                                                href="{{ Route('event') }}">
                                                <i class="bi bi-eye me-1"></i> Lihat Event
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>


            </main>
        </div>
        <!-- Footer -->
        {{-- @include('components.footer-user') --}}
    </div>
@endsection
