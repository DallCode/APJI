<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  </head>
  <body>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

  {{-- <nav class="navbar custom-nav">
      <div class="container-fluid">
          <a class="navbar-brand" href="#"><img src="{{ asset('assets/img/logo/apjiadmin.png') }}" alt=""></a>
              <form method="POST" action="">
                  <button class="btn btn-outline-danger ml-auto" type="submit">
                      <i class='bx bx-log-out'></i>
                  </button>
              </form>
      </div>
  </nav> --}}

      <!-- Navbar -->
      @include('components.navbar-admin')

          @yield('content')

      @include('components.sidebar-admin')

      {{-- <div class="container-fluid">
        <div class="row">

          <nav class="col-md-3 col-lg-2 d-md-block custom-sidebar">
            <div class="position-sticky pt-3">
              
              <div class="sidebar-label">Dashboard</div>
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="sidebar-link" href="{{ route('dashboard') }}"><i class='bx bxs-layout'></i> Dashboard</a>
                </li>
              </ul>

              <div class="sidebar-label">Menu</div>
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="sidebar-link" href=""><i class='bx bx-grid-horizontal'></i> Pengajuan</a>
                  <a class="sidebar-link" href="{{ route('event') }}"><i class='bx bx-grid-horizontal'></i> Event</a>
                </li>
              </ul>
              
          </nav>

          <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <h1>Dashboard</h1>

            <div class="card-container">
                <div class="card">
                    <div class="card-content">
                        <h2>Total Anggota</h2>
                        <p>100</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <h2>Anggota Terverifikasi</h2>
                        <p>89</p>
                    </div>
                </div>
                <div class="card menunggu">
                    <div class="card-content">
                        <h2>Menunggu Diverifikasi</h2>
                        <p>11</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <h2>Pengajuan</h2>
                        <p>71</p>
                    </div>
                </div>
            </div>

            <div class="table">
              <div class="tableheader">
                  <h6>Aktivitas</h6>
              </div>

              <div class="tablecontent">
                  <table>
                      <tbody>
                        <tr>
                          <td class="notif">User baru telah login.</td>
                          <td><a class="detail" href="">Lihat Detail</a></td>
                        </tr>
                        <tr>
                          <td class="notif">User baru telah login.</td>
                          <td><a class="detail" href="">Lihat Detail</a></td>
                        </tr>
                        <tr>
                          <td class="notif">User baru telah login.</td>
                          <td><a class="detail" href="">Lihat Detail</a></td>
                        </tr>
                        <tr>
                          <td class="notif">User baru telah login.</td>
                          <td><a class="detail" href="">Lihat Detail</a></td>
                        </tr>
                        <tr>
                          <td class="notif">User baru telah login.</td>
                          <td><a class="detail" href="">Lihat Detail</a></td>
                        </tr>
                      </tbody>
                  </table>
              </div>
            </div>

          </main>
        </div>
      </div> --}}

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>