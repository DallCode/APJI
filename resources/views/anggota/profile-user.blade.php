@extends('layout.profile-user')

@section('content')

<!-- Container -->
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <x-sidebar-user/>
        
        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <!-- Header Section -->
            <div class="header-section text-center py-4 bg-gradient">
                <h1 class="fw-bold text-black">Informasi Profil Anda</h1>
                <p class="text-dark">Perbarui informasi Anda untuk memastikan kami memiliki data yang akurat.</p>
            </div>
            
            <!-- Main Content -->
            <main class="profile-page">
                <!-- Profile Form Container -->
                <div class="profile-form-container mt-5">
                    <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
                        @csrf

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $dataPengguna->email }}">
                        </div>

                        <div class="form-group text-center mt-2">
                            <a href="{{ route('password.reset') }}" class="text-decoration-none">Reset Password</a>
                        </div>

                        <!-- Tipe Member -->
                        {{-- <div class="form-group">
                            <label for="tipe_member" class="form-label">Tipe Member</label>
                            <input type="text" name="tipe_member" id="tipe_member" class="form-control" value="{{ $dataPengguna->tipe_member }}">
                        </div> --}}

                        <!-- Nama Usaha -->
                        <div class="form-group">
                            <label for="nama_usaha" class="form-label">Nama Usaha</label>
                            <input type="text" name="nama_usaha" id="nama_usaha" class="form-control" value="{{ $dataPengguna->nama_usaha }}">
                        </div>

                        <!-- Alamat -->
                        <div class="form-group">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="3" class="form-control">{{ $dataPengguna->alamat }}</textarea>
                        </div>

                        <!-- Provinsi, Kota, Kecamatan -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <input type="text" name="provinsi" id="provinsi" class="form-control" value="{{ $dataPengguna->provinsi }}">
                            </div>
                            <div class="form-group">
                                <label for="kota" class="form-label">Kota</label>
                                <input type="text" name="kota" id="kota" class="form-control" value="{{ $dataPengguna->kota }}">
                            </div>
                            <div class="form-group">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <input type="text" name="kecamatan" id="kecamatan" class="form-control" value="{{ $dataPengguna->kecamatan }}">
                            </div>
                        </div>

                        <!-- Kode Pos -->
                        <div class="form-group">
                            <label for="kode_pos" class="form-label">Kode Pos</label>
                            <input type="text" name="kode_pos" id="kode_pos" class="form-control" value="{{ $dataPengguna->kode_pos }}">
                        </div>

                        <!-- No Telepon -->
                        <div class="form-group">
                            <label for="no_telp" class="form-label">No Telepon</label>
                            <input type="text" name="no_telp" id="no_telp" class="form-control" value="{{ $dataPengguna->no_telp }}">
                        </div>

                        <!-- Nama Pemilik -->
                        <div class="form-group">
                            <label for="nama_pemilik" class="form-label">Nama Pemilik</label>
                            <input type="text" name="nama_pemilik" id="nama_pemilik" class="form-control" value="{{ $dataPengguna->nama_pemilik }}">
                        </div>

                        <!-- No KTP, SKU, NPWP -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="no_ktp" class="form-label">No KTP</label>
                                <input type="text" name="no_ktp" id="no_ktp" class="form-control" value="{{ $dataPengguna->no_ktp }}">
                            </div>
                            <div class="form-group">
                                <label for="no_sku" class="form-label">No SKU</label>
                                <input type="text" name="no_sku" id="no_sku" class="form-control" value="{{ $dataPengguna->no_sku }}">
                            </div>
                            <div class="form-group">
                                <label for="no_npwp" class="form-label">No NPWP</label>
                                <input type="text" name="no_npwp" id="no_npwp" class="form-control" value="{{ $dataPengguna->no_npwp }}">
                            </div>
                        </div>

                        <!-- Kategori dan Jenis Usaha -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="k_usaha" class="form-label">Kategori Usaha</label>
                                <input type="text" name="k_usaha" id="k_usaha" class="form-control" value="{{ $dataPengguna->k_usaha }}">
                            </div>
                            <div class="form-group">
                                <label for="j_usaha" class="form-label">Jenis Usaha</label>
                                <input type="text" name="j_usaha" id="j_usaha" class="form-control" value="{{ $dataPengguna->j_usaha }}">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary" >Simpan</button>
                        </div>
                    </form>
              </div>
            </main>

        </main>
    </div>
</div>
@endsection

