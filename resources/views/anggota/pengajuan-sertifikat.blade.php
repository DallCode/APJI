@extends('layout.pengajuan-sertifikat')
@section('content')

    <!-- Container -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <x-sidebar-user />

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 content">
                <!-- Header Section -->
                <div class="header-section text-center py-4 bg-gradient">
                    <h1 class="fw-bold text-black">Pengajuan Sertifikat</h1>
                    <p class="text-dark">Ajukan sertifikat Anda sekarang!</p>
                </div>

                <!-- Statistics Section -->
                {{-- <section class="stats-section py-4">
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
        </section> --}}

                <!-- Recent Activities Table -->
                <section class="recent-activities-section container py-4 mt-4">
                    {{-- <h3 class="fw-bold text-primary mb-3">Sertifikasi</h3> --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle shadow-sm rounded-4 overflow-hidden">
                            <thead class="table-primary text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Sertifikasi</th>
                                    <th class="text-center">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $pengajuanHalal = \App\Models\PengajuanHalal::where(
                                        'id_pengguna',
                                        auth()->user()->dataPengguna->id_pengguna ?? null,
                                    )->first();
                                @endphp

                                @php
                                    $pengajuanKoki = \App\Models\PengajuanKoki::where(
                                        'id_pengguna',
                                        auth()->user()->dataPengguna->id_pengguna ?? null,
                                    )->first();
                                @endphp

                                @php
                                    $pengajuanAsistenKoki = \App\Models\PengajuanAsistenKoki::where(
                                        'id_pengguna',
                                        auth()->user()->dataPengguna->id_pengguna ?? null,
                                    )->first();
                                @endphp

                                <tr>
                                    <td>1</td>
                                    <td>Sertifikat Halal</td>
                                    <td class="text-center">
                                        @if (!$pengajuanHalal)
                                            <a class="btn btn-outline-primary btn-sm shadow-sm" style="width: 110px"
                                                data-bs-toggle="modal" data-bs-target="#modalHalal">
                                                <i class="bi bi-eye me-1"></i> Ajukan
                                            </a>
                                        @elseif($pengajuanHalal->status === 'menunggu')
                                            <a class="btn btn-outline-secondary btn-sm shadow-sm" style="width: 110px;pointer-events: none;color: #AEAEAE;text-decoration: none;cursor: default;"
                                                disabled>
                                                Menunggu
                                            </a>
                                        @elseif($pengajuanHalal->status === 'diterima')
                                            <a
                                                class="btn btn-outline-success btn-sm shadow-sm" style="width: 110px"
                                                data-bs-toggle="modal" data-bs-target="#modalPesanAdminAccept"
                                                data-pdf-url="{{ Storage::url($pengajuanHalal->file) }}">
                                                Diterima
                                            </a>
                                        @elseif($pengajuanHalal->status === 'ditolak')
                                            @php
                                                $filePath = $pengajuanHalal->file ?? null;
                                                $pesanTolak =
                                                    $filePath &&
                                                    \Illuminate\Support\Facades\Storage::disk('public')->exists(
                                                        $filePath,
                                                    )
                                                        ? \Illuminate\Support\Facades\Storage::disk('public')->get(
                                                            $filePath,
                                                        )
                                                        : 'Pesan tidak ditemukan.';
                                            @endphp
                                            <a class="btn btn-outline-danger btn-sm shadow-sm" style="width: 110px"
                                                data-bs-toggle="modal" data-bs-target="#modalPesanAdmin"
                                                data-pesan="{{ $pesanTolak }}"  data-status="ditolak" data-jenis-pengajuan="halal">
                                                Ditolak
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Sertifikat Koki</td>
                                    <td class="text-center">
                                        @if (!$pengajuanKoki)
                                            <a class="btn btn-outline-primary btn-sm shadow-sm" style="width: 110px"
                                                data-bs-toggle="modal" data-bs-target="#modalKoki">
                                                <i class="bi bi-eye me-1"></i> Ajukan
                                            </a>
                                        @elseif($pengajuanKoki->status === 'menunggu')
                                            <a class="btn btn-outline-secondary btn-sm shadow-sm" style="width: 110px;pointer-events: none;color: #AEAEAE;text-decoration: none;cursor: default;"
                                                disabled>
                                                Menunggu
                                            </a>
                                        @elseif($pengajuanKoki->status === 'diterima')
                                            <a class="btn btn-outline-success btn-sm shadow-sm" style="width: 110px"
                                                data-bs-toggle="modal" data-bs-target="#modalPesanAdminAccept"
                                                data-pdf-url="{{ Storage::url($pengajuanKoki->file) }}">
                                                Diterima
                                            </a>
                                            @elseif($pengajuanKoki->status === 'ditolak')
                                            @php
                                                $filePath = $pengajuanKoki->file ?? null;
                                                $pesanTolak =
                                                    $filePath &&
                                                    \Illuminate\Support\Facades\Storage::disk('public')->exists(
                                                        $filePath,
                                                    )
                                                        ? \Illuminate\Support\Facades\Storage::disk('public')->get(
                                                            $filePath,
                                                        )
                                                        : 'Pesan tidak ditemukan.';
                                            @endphp
                                            <a class="btn btn-outline-danger btn-sm shadow-sm" style="width: 110px"
                                                data-bs-toggle="modal" data-bs-target="#modalPesanAdmin"
                                                data-pesan="{{ $pesanTolak }}"  data-status="ditolak" data-jenis-pengajuan="koki">
                                                Ditolak
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Sertifikat asisten Koki</td>
                                    <td class="text-center">
                                        @if (!$pengajuanAsistenKoki)
                                            <a class="btn btn-outline-primary btn-sm shadow-sm" style="width: 110px"
                                                data-bs-toggle="modal" data-bs-target="#modalAsistenKoki">
                                                <i class="bi bi-eye me-1"></i> Ajukan
                                            </a>
                                        @elseif($pengajuanAsistenKoki->status === 'menunggu')
                                            <a class="btn btn-outline-secondary btn-sm shadow-sm" style="width: 110px;pointer-events: none;color: #AEAEAE;text-decoration: none;cursor: default;"
                                                disabled>
                                                Menunggu
                                            </a>
                                        @elseif($pengajuanAsistenKoki->status === 'diterima')
                                            <a class="btn btn-outline-success btn-sm shadow-sm" style="width: 110px"
                                                data-bs-toggle="modal" data-bs-target="#modalPesanAdminAccept"
                                                data-pdf-url="{{ Storage::url($pengajuanAsistenKoki->file) }}">
                                                Diterima
                                            </a>
                                            @elseif($pengajuanAsistenKoki->status === 'ditolak')
                                            @php
                                                $filePath = $pengajuanAsistenKoki->file ?? null;
                                                $pesanTolak =
                                                    $filePath &&
                                                    \Illuminate\Support\Facades\Storage::disk('public')->exists(
                                                        $filePath,
                                                    )
                                                        ? \Illuminate\Support\Facades\Storage::disk('public')->get(
                                                            $filePath,
                                                        )
                                                        : 'Pesan tidak ditemukan.';
                                            @endphp
                                            <a class="btn btn-outline-danger btn-sm shadow-sm" style="width: 110px"
                                                data-bs-toggle="modal" data-bs-target="#modalPesanAdmin"
                                                data-pesan="{{ $pesanTolak }}"  data-status="ditolak" data-jenis-pengajuan="asisten-koki">
                                                Ditolak
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Modal Sertifikat Halal -->
                <div class="modal fade" id="modalHalal" tabindex="-1" aria-labelledby="modalHalalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content shadow-lg rounded-4">
                            <div class="modal-header border-0 bg-primary text-white rounded-top">
                                <h5 class="modal-title fw-bold" id="modalHalalLabel">Formulir Pengajuan Sertifikat Halal
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <!-- Tambahkan ID pada form -->
                            <form id="formHalal" action="/ajukan-sertifikat-halal" method="POST">
                                @csrf
                                <div class="modal-body bg-light">
                                    <div class="mb-3">
                                        <label for="namaUsaha" class="form-label">Nama Usaha</label>
                                        <input type="text" class="form-control border-0 shadow-sm" id="namaUsaha"
                                            name="nama_usaha" placeholder="Masukkan nama usaha Anda" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamatUsaha" class="form-label">Alamat Usaha</label>
                                        <textarea class="form-control border-0 shadow-sm" id="alamatUsaha" name="alamat_usaha" rows="3"
                                            placeholder="Masukkan alamat usaha Anda" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenisUsaha" class="form-label">Jenis Usaha</label>
                                        <select class="form-select border-0 shadow-sm" id="jenisUsaha" name="jenis_usaha"
                                            required>
                                            <option value="" disabled selected>Pilih jenis usaha</option>
                                            <option value="Catering">Catering</option>
                                            <option value="Restoran">Restoran</option>
                                            <option value="Produk Makanan/Minuman">Produk Makanan/Minuman</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="produk" class="form-label">Nama Produk</label>
                                        <input type="text" class="form-control border-0 shadow-sm" id="produk"
                                            name="nama_produk" placeholder="Masukkan nama produk Anda" required>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 bg-light">
                                    <button type="button" class="btn btn-secondary rounded-3 px-4"
                                        data-bs-dismiss="modal">Batal</button>
                                    <!-- Ubah tombol menjadi type="button" -->
                                    <button type="button" class="btn btn-primary rounded-3 px-4"
                                        id="btnSubmitHalal">Ajukan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Update Sertifikat Halal -->
                <div class="modal fade" id="modalUpdateHalal" tabindex="-1" aria-labelledby="modalHalalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content shadow-lg rounded-4">
                            <div class="modal-header bg-primary text-white rounded-top border-0">
                                <h5 class="modal-title fw-bold" id="modalHalalLabel">Formulir Pengajuan Sertifikat Halal</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="formUpdateHalal" method="POST" action="{{ isset($pengajuanHalal) && $pengajuanHalal->id_detail ? route('updateUserHalal', $pengajuanHalal->id_detail) : '#' }}" enctype="multipart/form-data">
                                @csrf
                                
                                <input type="hidden" name="id_detail" id="id_detail" value="{{ $pengajuanHalal->id_detail ?? '' }}">
                                
                                <div class="mb-3">
                                    <label for="namaUsahaHalal" class="form-label">Nama Usaha</label>
                                    <input type="text" class="form-control border-0 shadow-sm" id="namaUsahaHalal" name="nama_usaha"
                                    value="{{ $pengajuanHalal->nama_usaha ?? '' }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="alamatUsahaHalal" class="form-label">Alamat Usaha</label>
                                    <textarea class="form-control border-0 shadow-sm" id="alamatUsahaHalal" name="alamat_usaha" rows="3" required>{{ $pengajuanHalal->alamat_usaha ?? '' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="jenisUsahaHalal" class="form-label">Jenis Usaha</label>
                                    <select class="form-select border-0 shadow-sm" id="jenisUsahaHalal" name="jenis_usaha" required>
                                        <option value="" disabled {{ !isset($pengajuanHalal) ? 'selected' : '' }}>Pilih jenis usaha</option>
                                        <option value="Catering" {{ isset($pengajuanHalal) && $pengajuanHalal->jenis_usaha == 'Catering' ? 'selected' : '' }}>Catering</option>
                                        <option value="Restoran" {{ isset($pengajuanHalal) && $pengajuanHalal->jenis_usaha == 'Restoran' ? 'selected' : '' }}>Restoran</option>
                                        <option value="Produk Makanan/Minuman" {{ isset($pengajuanHalal) && $pengajuanHalal->jenis_usaha == 'Produk Makanan/Minuman' ? 'selected' : '' }}>Produk Makanan/Minuman</option>
                                    </select>                    
                                </div>
                                <div class="mb-3">
                                    <label for="produkHalal" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control border-0 shadow-sm" id="produkHalal" name="nama_produk" 
                                        value="{{ $pengajuanHalal->nama_produk ?? '' }}" required>
                                </div>
                                
                                <div class="modal-footer border-0 bg-light">
                                    <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary rounded-3 px-4" id="btnSubmitHalal" 
                                        {{ isset($pengajuanHalal) && $pengajuanHalal->id_detail ? '' : 'disabled' }}>
                                        Ajukan
                                    </button>
                                </div>
                            </form>                        
                        </div>
                    </div>
                </div>

                <!-- Modal Sertifikat Koki -->
                <div class="modal fade" id="modalKoki" tabindex="-1" aria-labelledby="modalKokiLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content shadow-lg rounded-4">
                            <div class="modal-header bg-primary text-white rounded-top border-0">
                                <h5 class="modal-title fw-bold" id="modalKokiLabel">Formulir Pengajuan Sertifikat Koki
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="/ajukan-sertifikat-koki" method="POST" id="formKoki">
                                @csrf
                                <div class="modal-body bg-light">
                                    <div class="mb-3">
                                        <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control border-0 shadow-sm" id="namaLengkap"
                                            name="nama_lengkap" placeholder="Masukkan nama lengkap Anda" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengalamanKerja" class="form-label">Pengalaman Kerja</label>
                                        <textarea class="form-control border-0 shadow-sm" id="pengalamanKerja" name="pengalaman_kerja" rows="3"
                                            placeholder="Ceritakan pengalaman kerja Anda" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pendidikan" class="form-label">Pendidikan Terakhir</label>
                                        <input type="text" class="form-control border-0 shadow-sm" id="pendidikan"
                                            name="pendidikan_terakhir" placeholder="Masukkan pendidikan terakhir Anda"
                                            required>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 bg-light">
                                    <button type="button" class="btn btn-secondary rounded-3 px-4"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary rounded-3 px-4"
                                        id="btnSubmitKoki">Ajukan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Update Sertifikat Koki -->
                <div class="modal fade" id="modalUpdateKoki" tabindex="-1" aria-labelledby="modalKokiLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content shadow-lg rounded-4">
                            <div class="modal-header bg-primary text-white rounded-top border-0">
                                <h5 class="modal-title fw-bold" id="modalKokiLabel">Formulir Pengajuan Sertifikat Koki</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="formUpdateKoki" method="POST" action="{{ isset($pengajuanKoki) && $pengajuanKoki->id_detail ? route('updateUserKoki', $pengajuanKoki->id_detail) : '#' }}" enctype="multipart/form-data">
                                @csrf
                                
                                <input type="hidden" name="id_detail" id="id_detail_koki" value="{{ $pengajuanKoki->id_detail ?? '' }}">
                                
                                <div class="mb-3">
                                    <label for="namaLengkapKoki" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control border-0 shadow-sm" id="namaLengkapKoki" name="nama_lengkap"
                                    value="{{ $pengajuanKoki->nama_lengkap ?? '' }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="pengalamanKerjaKoki" class="form-label">Pengalaman Kerja</label>
                                    <textarea class="form-control border-0 shadow-sm" id="pengalamanKerjaKoki" name="pengalaman_kerja" rows="3" required>{{ $pengajuanKoki->pengalaman_kerja ?? '' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="pendidikanKoki" class="form-label">Pendidikan Terakhir</label>
                                    <input type="text" class="form-control border-0 shadow-sm" id="pendidikanKoki" name="pendidikan_terakhir" 
                                        value="{{ $pengajuanKoki->pendidikan_terakhir ?? '' }}" required>
                                </div>
                                
                                <div class="modal-footer border-0 bg-light">
                                    <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary rounded-3 px-4" id="btnSubmitKoki" 
                                        {{ isset($pengajuanKoki) && $pengajuanKoki->id_detail ? '' : 'disabled' }}>
                                        Ajukan
                                    </button>
                                </div>
                            </form>                        
                        </div>
                    </div>
                </div>

                <!-- Modal Sertifikat Asisten Koki -->
                <div class="modal fade" id="modalAsistenKoki" tabindex="-1" aria-labelledby="modalAsistenKokiLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content shadow-lg rounded-4">
                            <div class="modal-header bg-success text-white rounded-top border-0">
                                <h5 class="modal-title fw-bold" id="modalAsistenKokiLabel">Formulir Pengajuan Sertifikat
                                    Asisten Koki</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="/ajukan-sertifikat-asisten-koki" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body bg-light">
                                    <div class="mb-3">
                                        <label for="namaLengkapAsisten" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control border-0 shadow-sm"
                                            id="namaLengkapAsisten" name="nama_lengkap"
                                            placeholder="Masukkan nama lengkap Anda" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="keahlian" class="form-label">Keahlian Khusus</label>
                                        <textarea class="form-control border-0 shadow-sm" id="keahlian" name="keahlian_khusus" rows="3"
                                            placeholder="Ceritakan keahlian khusus Anda"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="suratPengantar" class="form-label">Surat Pengantar dari Perusahaan
                                            (opsional)</label>
                                        <input type="file" class="form-control border-0 shadow-sm" id="suratPengantar"
                                            name="surat_pengantar">
                                    </div>
                                </div>
                                <div class="modal-footer border-0 bg-light">
                                    <button type="button" class="btn btn-secondary rounded-3 px-4"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary rounded-3 px-4">Ajukan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Update Sertifikat Asisten Koki -->
                <div class="modal fade" id="modalUpdateAsistenKoki" tabindex="-1" aria-labelledby="modalAsistenKokiLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content shadow-lg rounded-4">
                            <div class="modal-header bg-success text-white rounded-top border-0">
                                <h5 class="modal-title fw-bold" id="modalAsistenKokiLabel">Formulir Pengajuan Sertifikat Asisten Koki</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="formUpdateAsistenKoki" method="POST" action="{{ isset($pengajuanAsistenKoki) && $pengajuanAsistenKoki->id_detail ? route('updateUserAsisten', $pengajuanAsistenKoki->id_detail) : '#' }}" enctype="multipart/form-data">
                                @csrf
                                
                                <input type="hidden" name="id_detail" id="id_detail_asisten_koki" value="{{ $pengajuanAsistenKoki->id_detail ?? '' }}">
                                
                                <div class="mb-3">
                                    <label for="namaLengkapAsisten" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control border-0 shadow-sm" id="namaLengkapAsisten" name="nama_lengkap"
                                        value="{{ $pengajuanAsistenKoki->nama_lengkap ?? '' }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="keahlian" class="form-label">Keahlian Khusus</label>
                                    <textarea class="form-control border-0 shadow-sm" id="keahlian" name="keahlian_khusus" rows="3" required>{{ $pengajuanAsistenKoki->keahlian_khusus ?? '' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="suratPengantar" class="form-label">Surat Pengantar dari Perusahaan (opsional)</label>
                                    <input type="file" class="form-control border-0 shadow-sm" id="suratPengantar" name="surat_pengantar">
                                </div>
                                
                                <div class="modal-footer border-0 bg-light">
                                    <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary rounded-3 px-4" id="btnSubmitAsistenKoki" 
                                        {{ isset($pengajuanAsistenKoki) && $pengajuanAsistenKoki->id_detail ? '' : 'disabled' }}>
                                        Ajukan
                                    </button>
                                </div>
                            </form>                        
                        </div>
                    </div>
                </div>

                <!-- Modal Pesan Admin -->
                <div class="modal fade" id="modalPesanAdmin" tabindex="-1" aria-labelledby="modalPesanAdminLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalPesanAdminLabel">Pesan dari Admin</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p id="pesanAdminContent"></p>
                            </div>
                            <div class="modal-footer">
                                <!-- Tombol Ajukan Kembali -->
                                <button type="button" class="btn btn-primary" id="btnAjukanKembali">Ajukan Kembali</button>
                                <!-- Tombol Tutup -->
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Tampilkan Sertifikat -->
                <div class="modal fade" id="modalPesanAdminAccept" tabindex="-1"
                    aria-labelledby="modalPesanAdminAcceptLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalPesanAdminAcceptLabel">Sertifikat Asisten Koki</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Tampilkan PDF -->
                                <embed id="pdfViewer" src="" type="application/pdf" width="100%"
                                    height="500px">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

            </main>


            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                console.log('JavaScript dimuat'); // Log untuk memastikan JS aktif

                // Logika untuk modalPesanAdmin
                const modalPesanAdmin = document.getElementById('modalPesanAdmin');
                if (modalPesanAdmin) {
                    console.log('Modal Pesan Admin ditemukan');
                    modalPesanAdmin.addEventListener('show.bs.modal', function(event) {
                        const button = event.relatedTarget; // Tombol yang memicu modal
                        const pesan = button.getAttribute('data-pesan'); // Ambil data-pesan dari tombol
                        const modalBody = modalPesanAdmin.querySelector('#pesanAdminContent');

                        // Tampilkan pesan di modal
                        modalBody.textContent = pesan || 'Tidak ada pesan.';
                        console.log('Pesan ditampilkan:', pesan);

                        // Tampilkan atau sembunyikan tombol "Ajukan Kembali" berdasarkan status
                        const btnAjukanKembali = modalPesanAdmin.querySelector('#btnAjukanKembali');
                        if (button.getAttribute('data-status') === 'ditolak') {
                            btnAjukanKembali.style.display = 'inline-block'; // Tampilkan tombol
                        } else {
                            btnAjukanKembali.style.display = 'none'; // Sembunyikan tombol
                        }

                        // Logika untuk tombol "Ajukan Kembali"
                        btnAjukanKembali.addEventListener('click', function() {
                            // Tutup modal pesan admin
                            const modalPesanAdminInstance = bootstrap.Modal.getInstance(modalPesanAdmin);
                            modalPesanAdminInstance.hide();

                            // Buka modal yang sesuai berdasarkan jenis pengajuan
                            const jenisPengajuan = button.getAttribute('data-jenis-pengajuan');
                            if (jenisPengajuan === 'halal') {
                                const modalUpdateHalal = new bootstrap.Modal(document.getElementById('modalUpdateHalal'));
                                modalUpdateHalal.show();
                            } else if (jenisPengajuan === 'koki') {
                                const modalUpdateKoki = new bootstrap.Modal(document.getElementById('modalUpdateKoki'));
                                modalUpdateKoki.show();
                            } else if (jenisPengajuan === 'asisten-koki') {
                                const modalUpdateAsistenKoki = new bootstrap.Modal(document.getElementById('modalUpdateAsistenKoki'));
                                modalUpdateAsistenKoki.show();
                            }
                        });
                    });
                } else {
                    console.error('Modal Pesan Admin tidak ditemukan di DOM');
                }

                // Logika untuk modalPesanAdminAccept (jika ada)
                const modalPesanAdminAccept = document.getElementById('modalPesanAdminAccept');
                if (modalPesanAdminAccept) {
                    modalPesanAdminAccept.addEventListener('show.bs.modal', function(event) {
                        const button = event.relatedTarget;
                        const pdfUrl = button.getAttribute('data-pdf-url');

                        console.log('URL file PDF:', pdfUrl); // Debug URL

                        const pdfViewer = modalPesanAdminAccept.querySelector('#pdfViewer');
                        if (pdfUrl) {
                            pdfViewer.src = pdfUrl;
                            console.log('File PDF berhasil dimuat:', pdfUrl);
                        } else {
                            console.error('File PDF tidak ditemukan atau URL kosong.');
                        }
                    });

                    modalPesanAdminAccept.addEventListener('hidden.bs.modal', function() {
                        const pdfViewer = modalPesanAdminAccept.querySelector('#pdfViewer');
                        pdfViewer.src = ''; // Reset saat modal ditutup
                        console.log('PDF Viewer di-reset.');
                    });
                } else {
                    console.error('Modal Pesan Admin Accept tidak ditemukan di DOM');
                }
            });


                // Tangkap tombol submit
                document.getElementById('btnSubmitHalal').addEventListener('click', function() {
                    // Ambil data dari input form
                    const namaUsaha = document.getElementById('namaUsaha').value;
                    const alamatUsaha = document.getElementById('alamatUsaha').value;
                    const jenisUsaha = document.getElementById('jenisUsaha').value;
                    const namaProduk = document.getElementById('produk').value;

                    // Validasi jika ada field yang kosong
                    if (!namaUsaha || !alamatUsaha || !jenisUsaha || !namaProduk) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Harap isi semua data sebelum melanjutkan!',
                        });
                        return;
                    }

                    // Tampilkan konfirmasi SweetAlert
                    Swal.fire({
                        title: 'Apakah data sudah sesuai?',
                        html: `
                        <strong>Nama Usaha:</strong> ${namaUsaha}<br>
                        <strong>Alamat Usaha:</strong> ${alamatUsaha}<br>
                        <strong>Jenis Usaha:</strong> ${jenisUsaha}<br>
                        <strong>Nama Produk:</strong> ${namaProduk}
                    `,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Ajukan!',
                        cancelButtonText: 'Periksa Lagi',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kirim formulir jika pengguna yakin
                            document.getElementById('formHalal').submit();
                        }
                    });
                });

                document.addEventListener('DOMContentLoaded', function() {
                // Event listener untuk form update halal
                document.getElementById('formUpdateHalal').addEventListener('submit', function(event) {
                    event.preventDefault(); // Mencegah pengiriman form

                    // Ambil data dari input form
                    const namaUsaha = document.getElementById('namaUsaha').value;
                    const alamatUsaha = document.getElementById('alamatUsaha').value;
                    const jenisUsaha = document.getElementById('jenisUsaha').value;
                    const produk = document.getElementById('produk').value;

                    // Validasi jika ada field yang kosong
                    // if (!namaUsaha || !alamatUsaha || !jenisUsaha || !produk) {
                    //     Swal.fire({
                    //         icon: 'error',
                    //         title: 'Oops...',
                    //         text: 'Harap isi semua data sebelum melanjutkan!',
                    //     });
                    //     return;
                    // }

                    // Tampilkan konfirmasi SweetAlert
                    Swal.fire({
                        title: 'Apakah data sudah sesuai?',
                        html: `
                        `,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Update!',
                        cancelButtonText: 'Periksa Lagi',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kirim formulir jika pengguna yakin
                            document.getElementById('formUpdateHalal').submit();
                        }
                    });
                });

                // Event listener untuk tombol edit (isi data ke modal)
                document.querySelectorAll('.btn-edit-halal').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const namaUsaha = this.getAttribute('data-nama-usaha');
                        const alamatUsaha = this.getAttribute('data-alamat-usaha');
                        const jenisUsaha = this.getAttribute('data-jenis-usaha');
                        const produk = this.getAttribute('data-nama-produk');

                        // Isi form dengan data yang ada
                        document.getElementById('namaUsaha').value = namaUsaha;
                        document.getElementById('alamatUsaha').value = alamatUsaha;
                        document.getElementById('jenisUsaha').value = jenisUsaha;
                        document.getElementById('produk').value = produk;

                        // Ubah action form untuk update
                        const form = document.getElementById('formUpdateHalal');
                        form.action = `/update-sertifikat-halal/${id}`;

                        // Tampilkan modal
                        new bootstrap.Modal(document.getElementById('modalUpdateHalal')).show();
                    });
                });
            });


            document.addEventListener('DOMContentLoaded', function() {
            // Event listener untuk form update koki
            document.getElementById('formUpdateKoki').addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah pengiriman form

                // Ambil data dari input form
                const namaLengkap = document.getElementById('namaLengkap').value;
                const pengalamanKerja = document.getElementById('pengalamanKerja').value;
                const pendidikan = document.getElementById('pendidikan').value;

                // Tampilkan konfirmasi SweetAlert
                Swal.fire({
                    title: 'Apakah data sudah sesuai?',
                    html: `
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Ajukan!',
                    cancelButtonText: 'Periksa Lagi',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim formulir jika pengguna yakin
                        document.getElementById('formUpdateKoki').submit();
                    }
                });
            });
        });

                    document.addEventListener('DOMContentLoaded', function() {
                    // Event listener untuk form update asisten koki
                    document.getElementById('formUpdateAsistenKoki').addEventListener('submit', function(event) {
                        event.preventDefault(); // Mencegah pengiriman form

                        // Ambil data dari input form
                        const namaLengkap = document.getElementById('namaLengkapAsisten').value;
                        const keahlian = document.getElementById('keahlian').value;
                        const suratPengantar = document.getElementById('suratPengantar').files.length > 0 ? 'Sudah diunggah' : 'Tidak ada file';

                        // Tampilkan konfirmasi SweetAlert
                        Swal.fire({
                            title: 'Apakah data sudah sesuai?',
                            html: `
                            `,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Ajukan!',
                            cancelButtonText: 'Periksa Lagi',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Kirim formulir jika pengguna yakin
                                document.getElementById('formUpdateAsistenKoki').submit();
                            }
                        });
                    });
                });




                document.getElementById('formKoki').addEventListener('submit', function(event) {
                    event.preventDefault(); // Mencegah pengiriman form

                    // Ambil data dari input form
                    const namaLengkap = document.getElementById('namaLengkap').value;
                    const pengalamanKerja = document.getElementById('pengalamanKerja').value;
                    const pendidikanTerakhir = document.getElementById('pendidikan').value;

                    // Validasi jika ada field yang kosong
                    if (!namaLengkap || !pengalamanKerja || !pendidikanTerakhir) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Harap isi semua data sebelum melanjutkan!',
                        });
                        return;
                    }

                    // Tampilkan konfirmasi SweetAlert
                    Swal.fire({
                        title: 'Apakah data sudah sesuai?',
                        html: `
                    <strong>Nama Lengkap:</strong> ${namaLengkap}<br>
                    <strong>Pengalaman Kerja:</strong> ${pengalamanKerja}<br>
                    <strong>Pendidikan Terakhir:</strong> ${pendidikanTerakhir}<br>
                `,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Ajukan!',
                        cancelButtonText: 'Periksa Lagi',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kirim formulir jika pengguna yakin
                            document.getElementById('formKoki').submit();
                        }
                    });
                });

                // Tangkap tombol submit
                document.querySelector('#modalAsistenKoki form').addEventListener('submit', function(e) {
                    e.preventDefault(); // Mencegah form untuk langsung submit

                    // Ambil data dari input form
                    const namaLengkapAsisten = document.getElementById('namaLengkapAsisten').value;
                    const keahlian = document.getElementById('keahlian').value;
                    const suratPengantar = document.getElementById('suratPengantar').files[0];

                    // Validasi jika nama dan keahlian kosong
                    if (!namaLengkapAsisten || !keahlian) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Harap isi semua data sebelum melanjutkan!',
                        });
                        return;
                    }

                    // Tampilkan konfirmasi SweetAlert
                    Swal.fire({
                        title: 'Apakah data sudah sesuai?',
                        html: `
                            <strong>Nama Lengkap:</strong> ${namaLengkapAsisten}<br>
                            <strong>Keahlian Khusus:</strong> ${keahlian}<br>
                            <strong>Surat Pengantar:</strong> ${suratPengantar ? suratPengantar.name : 'Tidak ada file'}<br>
                        `,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Ajukan!',
                        cancelButtonText: 'Periksa Lagi',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kirim formulir jika pengguna yakin
                            this.submit(); // Mengirimkan form jika user menekan "Ya, Ajukan!"
                        }
                    });
                });

            </script>

            

        </div>
    </div>
@endsection
