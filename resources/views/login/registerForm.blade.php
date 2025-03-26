<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body>
    <div class="registration-container">
        <div class="progress-bar">
            <div class="progress-step active">1</div>
            <div class="progress-step">2</div>
            <div class="progress-step">3</div>
            <div class="progress-step">4</div>
        </div>

        <form id="multi-step-form" action="{{ route('register') }}" method="POST">
            @csrf
            <!-- Step 1 - Basic Information -->
            <div class="step active" id="step-1">
                <div class="registration-header">
                    <h1>Informasi dasar</h1>
                    <p>Masukan informasi dasar</p>
                </div>

                <div class="input-group">
                    <input type="email" name="email" placeholder="Email Usaha" required>
                    <i class="fas fa-envelope"></i>
                </div>

                <div class="input-group">
                    <input type="text" name="nama_usaha" placeholder="Nama Usaha" required>
                    <i class="fas fa-building"></i>
                </div>

                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class="fas fa-lock"></i>
                </div>

                <div class="input-group">
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
                    <i class="fas fa-lock"></i>
                </div>

                <div class="navigation-buttons">
                    <button type="button" class="btn" onclick="nextStep()">Next</button>
                </div>

                <p class="text-center mt-3">Bagian dari kami? <a href="{{ route('login') }}">Masuk</a></p>
            </div>

            <!-- Step 2 - Address Information -->
            <div class="step" id="step-2">
                <div class="registration-header">
                    <h1>Detail Alamat</h1>
                    <p>Masukan alamat usaha anda</p>
                </div>

                <div class="input-group">
                    <input type="text" name="alamat" placeholder="Alamat" required>
                    <i class="fas fa-map-marker-alt"></i>
                </div>

                <div class="input-group">
                    <input type="text" name="provinsi" placeholder="Provinsi" required>
                    <i class="fas fa-globe"></i>
                </div>

                <div class="input-group">
                    <input type="text" name="kota" placeholder="Kota" required>
                    <i class="fas fa-city"></i>
                </div>

                <div class="input-group">
                    <input type="text" name="kecamatan" placeholder="Kecamatan" required>
                    <i class="fas fa-map-signs"></i>
                </div>

                <div class="input-group">
                    <input type="text" name="kode_pos" placeholder="Kode Pos" required>
                    <i class="fas fa-mail-bulk"></i>
                </div>

                <div class="input-group">
                    <input type="tel" name="no_telp" placeholder="No Telepon" required>
                    <i class="fas fa-phone"></i>
                </div>

                <div class="navigation-buttons">
                    <button type="button" class="btn btn-secondary" onclick="prevStep()">Back</button>
                    <button type="button" class="btn" onclick="nextStep()">Next</button>
                </div>
            </div>

            <!-- Step 3 - Owner Information -->
            <div class="step" id="step-3">
                <div class="registration-header">
                    <h1>Detail Pemilik</h1>
                    <p>Masukan informais mengenai pemilik</p>
                </div>

                <div class="input-group">
                    <input type="text" name="nama_pemilik" placeholder="Nama Pemilik" required>
                    <i class="fas fa-user"></i>
                </div>

                <div class="input-group">
                    <input type="text" name="no_ktp" placeholder="KTP/NIK" required>
                    <i class="fas fa-id-card"></i>
                </div>

                <div class="input-group">
                    <input type="text" name="no_sku" placeholder="SKU/PIRT">
                    <i class="fas fa-receipt"></i>
                </div>

                <div class="input-group">
                    <input type="text" name="no_npwp" placeholder="NPWP">
                    <i class="fas fa-file-invoice"></i>
                </div>

                <div class="navigation-buttons">
                    <button type="button" class="btn btn-secondary" onclick="prevStep()">Back</button>
                    <button type="button" class="btn" onclick="nextStep()">Next</button>
                </div>
            </div>

            <!-- Step 4 - Business Qualification -->
            <div class="step" id="step-4">
                <div class="registration-header">
                    <h1>Detail Usaha</h1>
                    <p>Detail untuk usaha anda</p>
                </div>

                <div class="input-group">
                    <select name="k_usaha" required>
                        <option value="">Kualifikasi Usaha</option>
                        <option value="Mikro">Mikro</option>
                        <option value="Kecil">Kecil</option>
                        <option value="Menengah">Menengah</option>
                    </select>
                    <i class="fas fa-chart-line"></i>
                </div>

                <div class="input-group">
                    <select name="j_usaha" required>
                        <option value="">Jenis Usaha</option>
                        <option value="Makanan">Makanan</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Jasa">Jasa</option>
                    </select>
                    <i class="fas fa-briefcase"></i>
                </div>

                <div class="navigation-buttons">
                    <button type="button" class="btn btn-secondary" onclick="prevStep()">Back</button>
                    <button type="submit" class="btn">Register</button>
                </div>
            </div>
        </form>
    </div>

    <script src="{{ asset('assets/js/register.js') }}"></script> <!-- Pastikan ini diakhiri dengan </script> -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        // Menampilkan Toastify saat ada pesan flash
        @if (Session::has('success'))
            Toastify({
                text: "{{ Session::get('success') }}",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                stopOnFocus: true,
            }).showToast();
        @endif

        @if (Session::has('error'))
            Toastify({
                text: "{{ Session::get('error') }}",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                stopOnFocus: true,
            }).showToast();
        @endif
    </script>
</body>

</html>