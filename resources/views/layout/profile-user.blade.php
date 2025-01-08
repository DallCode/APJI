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
</head>
<body>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

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

</body>
</html>
