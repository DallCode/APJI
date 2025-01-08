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
            <main class="">
                <!-- Profile Header Section -->
                {{-- <div class="profile-header text-center py-4 bg-gradient">
                    <h1 class="fw-bold text-white">Edit Profil</h1>
                    <p class="text-white-50">Perbarui informasi akun Anda</p>
                </div> --}}

                <!-- Profile Form -->
                <div class="profile-form-container mt-5">
                    <form action="/update-profile" method="POST" class="shadow-sm p-4 rounded bg-white">
                        @csrf
                        <!-- Profile Picture Upload -->
                        {{-- <div class="mb-4 text-center">
                            <label for="profilePicture" class="form-label fw-bold">Foto Profil</label>
                            <div class="profile-img mb-3">
                                <img src="https://via.placeholder.com/150" alt="Profile Picture" class="rounded-circle img-fluid">
                            </div>
                            <input type="file" name="profile_picture" id="profilePicture" class="form-control">
                        </div> --}}

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control" value="John Doe">
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="john.doe@example.com">
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Telepon</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="+62 123 456 789">
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold">Alamat</label>
                            <textarea name="address" id="address" rows="3" class="form-control">Jl. Example No. 123, Jakarta, Indonesia</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </main>

        </main>
    </div>
</div>
@endsection

