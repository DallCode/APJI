@extends('layout.kelayakan-usaha')
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <x-sidebar-user />

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <!-- Header Section -->
            <div class="header-section text-center py-4 bg-gradient">
                <h1 class="fw-bold text-black">Kelayakan Usaha</h1>
                <p class="text-dark">Ajukan evaluasi kelayakan usaha Anda sekarang!</p>
            </div>

            <!-- Recent Activities Table -->
            <section class="recent-activities-section container py-4 mt-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle shadow-sm rounded-4 overflow-hidden">
                        <thead class="table-primary text-white">
                            <tr>
                                <th>#</th>
                                <th>Jenis Evaluasi</th>
                                <th class="text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $kelayakanFinansial = \App\Models\KelayakanFinansial::where(
                                    'id_pengguna',
                                    auth()->user()->dataPengguna->id_pengguna ?? null,
                                )->first();
                            @endphp

                            @php
                                $kelayakanOperasional = \App\Models\KelayakanOperasional::where(
                                    'id_pengguna',
                                    auth()->user()->dataPengguna->id_pengguna ?? null,
                                )->first();
                            @endphp

                            @php
                                $kelayakanPemasaran = \App\Models\KelayakanPemasaran::where(
                                    'id_pengguna',
                                    auth()->user()->dataPengguna->id_pengguna ?? null,
                                )->first();
                            @endphp

                            <tr>
                                <td>1</td>
                                <td>Kelayakan Finansial</td>
                                <td class="text-center">
                                    @if (!$kelayakanFinansial)
                                        <a class="btn btn-outline-primary btn-sm shadow-sm" style="width: 110px"
                                            data-bs-toggle="modal" data-bs-target="#modalHalal">
                                            <i class="bi bi-eye me-1"></i> Ajukan
                                        </a>
                                    @elseif($kelayakanFinansial->status === 'menunggu')
                                        <button class="btn btn-outline-secondary btn-sm shadow-sm" style="width: 110px"
                                            disabled>
                                            Menunggu
                                        </button>
                                    @elseif($kelayakanFinansial->status === 'diterima')
                                        <button class="btn btn-outline-success btn-sm shadow-sm" style="width: 110px"
                                            data-bs-toggle="modal" data-bs-target="#modalPesanAdmin"
                                            data-pesan="{{ $kelayakanFinansial->catatan_admin }}">
                                            Diterima
                                        </button>
                                    @elseif($kelayakanFinansial->status === 'ditolak')
                                        <button class="btn btn-outline-danger btn-sm shadow-sm" style="width: 110px"
                                            data-bs-toggle="modal" data-bs-target="#modalPesanAdmin"
                                            data-pesan="{{ $kelayakanFinansial->catatan_admin }}">
                                            Ditolak
                                        </button>
                                    @endif
                                </td>    
                            </tr>


                            <tr>
                                <td>2</td>
                                <td>Kelayakan Operasional</td>
                                <td class="text-center">
                                    @if (!$kelayakanOperasional)
                                        <a class="btn btn-outline-primary btn-sm shadow-sm" style="width: 110px"
                                            data-bs-toggle="modal" data-bs-target="#modalHalal">
                                            <i class="bi bi-eye me-1"></i> Ajukan
                                        </a>
                                    @elseif($kelayakanOperasional->status === 'menunggu')
                                        <button class="btn btn-outline-secondary btn-sm shadow-sm" style="width: 110px"
                                            disabled>
                                            Menunggu
                                        </button>
                                    @elseif($kelayakanOperasional->status === 'diterima')
                                        <button class="btn btn-outline-success btn-sm shadow-sm" style="width: 110px"
                                            data-bs-toggle="modal" data-bs-target="#modalPesanAdmin"
                                            data-pesan="{{ $kelayakanOperasional->catatan_admin }}">
                                            Diterima
                                        </button>
                                    @elseif($kelayakanOperasional->status === 'ditolak')
                                        <button class="btn btn-outline-danger btn-sm shadow-sm" style="width: 110px"
                                            data-bs-toggle="modal" data-bs-target="#modalPesanAdmin"
                                            data-pesan="{{ $kelayakanOperasional->catatan_admin }}">
                                            Ditolak
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Kelayakan Pemasaran</td>
                                <td class="text-center">
                                    @if (!$kelayakanPemasaran)
                                        <a class="btn btn-outline-primary btn-sm shadow-sm" style="width: 110px"
                                            data-bs-toggle="modal" data-bs-target="#modalHalal">
                                            <i class="bi bi-eye me-1"></i> Ajukan
                                        </a>
                                    @elseif($kelayakanPemasaran->status === 'menunggu')
                                        <button class="btn btn-outline-secondary btn-sm shadow-sm" style="width: 110px"
                                            disabled>
                                            Menunggu
                                        </button>
                                    @elseif($kelayakanPemasaran->status === 'diterima')
                                        <button class="btn btn-outline-success btn-sm shadow-sm" style="width: 110px"
                                            data-bs-toggle="modal" data-bs-target="#modalPesanAdmin"
                                            data-pesan="{{ $kelayakanPemasaran->catatan_admin }}">
                                            Diterima
                                        </button>
                                    @elseif($kelayakanPemasaran->status === 'ditolak')
                                        <button class="btn btn-outline-danger btn-sm shadow-sm" style="width: 110px"
                                            data-bs-toggle="modal" data-bs-target="#modalPesanAdmin"
                                            data-pesan="{{ $kelayakanPemasaran->catatan_admin }}">
                                            Ditolak
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Modal Kelayakan Finansial -->
            <div class="modal fade" id="modalFinansial" tabindex="-1" aria-labelledby="modalFinansialLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content shadow-lg rounded-4">
                        <div class="modal-header bg-primary text-white rounded-top border-0">
                            <h5 class="modal-title fw-bold" id="modalFinansialLabel">Formulir Pengajuan Kelayakan Finansial</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/ajukan-kelayakan-finansial" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body bg-light">
                                <div class="mb-3">
                                    <label for="namaUsaha" class="form-label">Nama Usaha</label>
                                    <input type="text" class="form-control border-0 shadow-sm" id="namaUsaha" name="nama_usaha" placeholder="Masukkan nama usaha Anda" required>
                                </div>
                                <div class="mb-3">
                                    <label for="laporanKeuangan" class="form-label">Upload Laporan Keuangan</label>
                                    <input type="file" class="form-control border-0 shadow-sm" id="laporanKeuangan" name="laporan_keuangan" required>
                                </div>
                            </div>
                            <div class="modal-footer border-0 bg-light">
                                <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary rounded-3 px-4">Ajukan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Kelayakan Operasional -->
            <div class="modal fade" id="modalOperasional" tabindex="-1" aria-labelledby="modalOperasionalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content shadow-lg rounded-4">
                        <div class="modal-header bg-primary text-white rounded-top border-0">
                            <h5 class="modal-title fw-bold" id="modalOperasionalLabel">Formulir Pengajuan Kelayakan Operasional</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/ajukan-kelayakan-operasional" method="POST">
                            @csrf
                            <div class="modal-body bg-light">
                                <div class="mb-3">
                                    <label for="namaUsaha" class="form-label">Nama Usaha</label>
                                    <input type="text" class="form-control border-0 shadow-sm" id="namaUsaha" name="nama_usaha" placeholder="Masukkan nama usaha Anda" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsiOperasional" class="form-label">Deskripsi Operasional</label>
                                    <textarea class="form-control border-0 shadow-sm" id="deskripsiOperasional" name="deskripsi_operasional" rows="3" placeholder="Jelaskan operasional usaha Anda" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer border-0 bg-light">
                                <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary rounded-3 px-4">Ajukan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Kelayakan Pemasaran -->
            <div class="modal fade" id="modalPemasaran" tabindex="-1" aria-labelledby="modalPemasaranLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content shadow-lg rounded-4">
                        <div class="modal-header bg-primary text-white rounded-top border-0">
                            <h5 class="modal-title fw-bold" id="modalPemasaranLabel">Formulir Pengajuan Kelayakan Pemasaran</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/ajukan-kelayakan-pemasaran" method="POST">
                            @csrf
                            <div class="modal-body bg-light">
                                <div class="mb-3">
                                    <label for="namaUsaha" class="form-label">Nama Usaha</label>
                                    <input type="text" class="form-control border-0 shadow-sm" id="namaUsaha" name="nama_usaha" placeholder="Masukkan nama usaha Anda" required>
                                </div>
                                <div class="mb-3">
                                    <label for="strategiPemasaran" class="form-label">Strategi Pemasaran</label>
                                    <textarea class="form-control border-0 shadow-sm" id="strategiPemasaran" name="strategi_pemasaran" rows="3" placeholder="Jelaskan strategi pemasaran usaha Anda" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer border-0 bg-light">
                                <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary rounded-3 px-4">Ajukan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modalPesanAdmin = document.getElementById('modalPesanAdmin');
                if (modalPesanAdmin) {
                    modalPesanAdmin.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget; // Tombol yang memicu modal
                        const pesan = button.getAttribute('data-pesan'); // Ambil data-pesan dari tombol
                        const modalBody = modalPesanAdmin.querySelector('#pesanAdminContent');
                        
                        // Tampilkan pesan di modal
                        modalBody.textContent = pesan || 'Tidak ada pesan.';
                    });
                }
            });
        </script>

    </div>
    <!-- Footer -->
{{-- @include('components.footer-user') --}}
</div>
@endsection