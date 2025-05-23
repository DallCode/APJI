<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset('assets/css/user.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body>


    <!-- Navbar -->
    @include('components.navbar-user')

        @yield('content')

    {{-- @include('components.sidebar-user') --}}

    {{-- <div class="container mt-5">
        <h1>Edit Profil</h1>
        <form action="#" method="POST">
            @csrf
            <!-- Form fields untuk edit profil (sama seperti di halaman profil sebelumnya) -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $dataPengguna->email) }}">
            </div>
            <!-- Tambahkan input lainnya sesuai kebutuhan -->
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        // Notifikasi setelah pengajuan diterima
        function showToastSuccess(message) {
            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: "top", // Posisi atas
                position: "right", // Posisi kanan
                backgroundColor: "#4CAF50", // Warna hijau untuk sukses
            }).showToast();
        }
    
        // Notifikasi setelah pengajuan ditolak
        function showToastError(message) {
            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#FF5733", // Warna merah untuk error
            }).showToast();
        }
    
        // Cek apakah ada pesan sukses atau error dari session Laravel
        @if(session('success'))
            showToastSuccess("{{ session('success') }}");
        @endif
    
        @if(session('error'))
            showToastError("{{ session('error') }}");
        @endif
    </script>
    

</body>
</html>
