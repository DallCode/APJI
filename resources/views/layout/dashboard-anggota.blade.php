<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset('assets/css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    <script src="{{ asset('assets/js/sidebar.js') }}"></script>
</head>

<body>
    
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    {{-- <header>
        <h1>Selamat datang, Anggota!</h1>
        <p>Anda berhasil login sebagai Anggota.</p>
    </header> --}}
    {{-- <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form> --}}

    <!-- Navbar -->
    @include('components.navbar-user')

        @yield('content')
        
    {{-- @include('components.footer-user') --}}
    {{-- @include('components.sidebar-user') --}}



    <!-- Container -->
    {{-- <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <x-sidebar-user/>

           <!-- Main Content -->
           <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <!-- Header Section -->
            <div class="header-section text-center py-4 bg-gradient">
                <h1 class="fw-bold text-black">Selamat Datang di Dashboard APJI</h1>
                <p class="text-dark">Asosiasi Pengusaha Jasa Boga Indonesia</p>
            </div>
        
            <!-- Statistics Section -->
            <section class="stats-section py-4">
                <div class="container">
                    <div class="row g-4 text-center">
                        <!-- Pengajuan Sertifikat Card -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-lg rounded-4 p-3 d-flex align-items-center justify-content-center" style="transition: transform 0.3s ease-in-out; height: 160px;">
                                <div class="text-center">
                                    <!-- Logo Icon for Pengajuan Sertifikat -->
                                    <i class="bx bx-award text-primary" style="font-size: 4rem; margin-bottom: 8px;"></i>
                                    <!-- Text Below Logo -->
                                    <h5 class="mt-0 fw-bold text-dark" style="font-size: 1.20rem;">Pengajuan Sertifikat</h5>
                                </div>
                            </div>
                        </div>
        
                        <!-- Kelayakan Usaha Card -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-lg rounded-4 p-3 d-flex align-items-center justify-content-center" style="transition: transform 0.3s ease-in-out; height: 160px;">
                                <div class="text-center">
                                    <!-- Logo Icon for Kelayakan Usaha -->
                                    <i class="bx bx-check-shield text-success" style="font-size: 4rem; margin-bottom: 8px;"></i>
                                    <!-- Text Below Logo -->
                                    <h5 class="mt-0 fw-bold text-dark" style="font-size: 1.20rem;">Kelayakan Usaha</h5>
                                </div>
                            </div>
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
                                <th>#</th>
                                <th>Event</th>
                                <th class="text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>User baru telah login.</td>
                                <td class="text-center">
                                    <a class="btn btn-outline-primary btn-sm shadow-sm" style="width: 110px" href="#">
                                        <i class="bi bi-eye me-1"></i> Lihat Detail
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Pengajuan Sertifikat baru diterima.</td>
                                <td class="text-center">
                                    <a class="btn btn-outline-primary btn-sm shadow-sm" style="width: 110px" href="#">
                                        <i class="bi bi-eye me-1"></i> Lihat Detail
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Program Pelatihan selesai.</td>
                                <td class="text-center">
                                    <a class="btn btn-outline-primary btn-sm shadow-sm" style="width: 110px" href="#">
                                        <i class="bi bi-eye me-1"></i> Lihat Detail 
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
        </div>
    </div> --}}

    
    <script src="{{ asset('assets/js/sidebar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
