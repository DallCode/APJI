@extends('layout.dashboard')
@section('content')

<div class="container-fluid">
  <div class="row">

    <x-sidebar-admin/>

    <main class="col-md-9 ms-sm-auto col-lg-10 content">
      <h1>Dashboard</h1>

      <div class="card-container">
          <div class="card">
              <div class="card-content">
                  <h2>Total Anggota</h2>
                  <p>{{ $datapengguna }}</p>
              </div>
          </div>
          <div class="card">
              <div class="card-content">
                  <h2>Anggota Terverifikasi</h2>
                  <p>{{ $keanggotaan }}</p>
              </div>
          </div>
          <div class="card menunggu">
              <div class="card-content">
                  <h2>Total Pengajuan</h2>
                  <p>{{ $totalPengajuan }}</p>
              </div>
          </div>
          <div class="card">
              <div class="card-content">
                  <h2>Total Kelayakan</h2>
                  <p>{{ $totalKelayakan }}</p>
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
                @foreach($recentUsers as $user)
                  <tr>
                      <td class="notif">User baru {{ $user->email }} telah bergabung.</td>
                      <td><a class="detail" href="#" data-bs-toggle="modal" data-bs-target="#userModal{{ $user->id }}">Lihat Detail</a></td>
                  </tr>

                  <!-- Modal untuk setiap user -->
                  <div class="modal fade" id="userModal{{ $user->id }}" tabindex="-1" aria-labelledby="userModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="userModalLabel{{ $user->id }}">Detail Pengguna: {{ $user->email }}</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <ul>
                            <li><strong>Email:</strong> {{ $user->email }}</li>
                            {{-- <li><strong>Nama Usaha:</strong> {{ $user->nama_usaha }}</li> --}}
                            <li><strong>Status:</strong> {{ $user->status }}</li>
                            <li><strong>Role:</strong> {{ $user->role }}</li>
                            <!-- Anda bisa menambahkan lebih banyak detail jika diperlukan -->
                          </ul>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </tbody>
          </table>
      </div>
      <!-- Pagination -->
      <div class="d-flex justify-content-left mt-3">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                @if ($recentUsers->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $recentUsers->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo; Previous</span>
                        </a>
                    </li>
                @endif
    
                @foreach ($recentUsers->getUrlRange(1, $recentUsers->lastPage()) as $page => $url)
                    <li class="page-item {{ $recentUsers->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
    
                @if ($recentUsers->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $recentUsers->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">Next &raquo;</span>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </nav>
    </div>   
      </div>
    </main>
  </div>
</div>
@endsection