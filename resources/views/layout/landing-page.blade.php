<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asosiasi Pengusaha Tataboga Jawa Barat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</head>

<body class="index-page" style="background-color:#">

  @include('components.navbar-landing-page')

    @yield('content')

  @include('components.footer-landing-page')

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="{{ asset ('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script>
        // Mengubah teks setelah 3 detik
        setTimeout(function() {
            document.getElementById("hero-description").innerHTML = "Meningkatkan Kualitas dan Ketersediaan Kuliner di Jawa Barat";
        }, 3000);
    </script>

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