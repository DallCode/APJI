@extends('layout.landing-page')
@section('content')
  <!-- Hero Section -->
  <section class="hero d-flex align-items-center" id="beranda">
    <div class="hero-image"></div> <!-- Tambahkan div untuk gambar latar belakang -->
    <div class="container text-center text-white">
        <h1 class="display-3 fw-bold animate__animated animate__fadeInDown">
            Asosiasi Pengusaha Tataboga Jawa Barat
        </h1>
        <p class="lead mt-4 animate__animated animate__fadeInUp">
            Memajukan Industri Kuliner Jawa Barat Melalui Inovasi dan Kolaborasi
        </p>
        <div class="mt-5 animate__animated animate__zoomIn">
            <a href="{{ route('login')}}" class="btn btn-primary btn-lg me-3">Login</a>
            <a href="{{ route('registerShow')}}" class="btn btn-outline-light btn-lg">Menjadi Anggota</a>
        </div>
    </div>
</section>


<!-- About Section -->
<section id="tentang" class="py-5" style="background: linear-gradient(135deg, #f5f5f5, #ffffff); color: #002f5b;">
    <div class="container">
        <!-- Judul Tentang Kami dengan latar belakang khusus -->
        <h2 class="text-center fw-bold mb-5 about-title">Tentang Kami</h2>
        <div class="row">
            <!-- Sub Judul -->
            <div class="col-12 text-center mb-4">
                <h2 class="fw-bold animate__animated animate__fadeInUp">Kami Menciptakan Identitas Industri Kuliner Indonesia</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <!-- Gambar -->
            <div class="col-lg-6 mb-4 animate__animated animate__zoomIn">
                <img src="{{ asset ('assets/img/logo/apji1.png')}}" alt="Tentang Kami" class="img-fluid rounded-3 shadow-lg">
            </div>
            <!-- Deskripsi -->
            <div class="col-lg-6 animate__animated animate__fadeInRight">
                <p class="lead">
                    <span class="fw-bold text-dark">Indonesia</span> itu kaya. Kaya sumber daya alam dan sumber daya manusia. Jelas ini suatu anugerah yang belum tentu dimiliki negara lain. Namun "pemberian" itu tak akan menjadi apa-apa, tanpa adanya sentuhan orang-orang kreatif yang membuatnya menjadi bernilai tambah. Tak hanya nilai tambah ekonomis, tapi juga nilai tambah estetika.
                </p>
                <div class="d-flex flex-wrap mt-4 justify-content-center">
                    <span class="badge bg-primary text-white px-3 py-2 m-1 shadow-sm hover-badge">INDUSTRI</span>
                    <span class="badge bg-primary text-white px-3 py-2 m-1 shadow-sm hover-badge">WEDDING</span>
                    <span class="badge bg-primary text-white px-3 py-2 m-1 shadow-sm hover-badge">OFFSHORE</span>
                    <span class="badge bg-primary text-white px-3 py-2 m-1 shadow-sm hover-badge">KORPORASI & PEMERINTAH</span>
                    <span class="badge bg-primary text-white px-3 py-2 m-1 shadow-sm hover-badge">RUMAH SAKIT</span>
                    <span class="badge bg-primary text-white px-3 py-2 m-1 shadow-sm hover-badge">RESTORAN</span>
                    <span class="badge bg-primary text-white px-3 py-2 m-1 shadow-sm hover-badge">BAKERY</span>
                    <span class="badge bg-primary text-white px-3 py-2 m-1 shadow-sm hover-badge">SUPPLIER BAHAN BAKU MAKANAN</span>
                    <span class="badge bg-primary text-white px-3 py-2 m-1 shadow-sm hover-badge">INDUSTRI BUMBU MASAKAN</span>
                    <span class="badge bg-primary text-white px-3 py-2 m-1 shadow-sm hover-badge">PACKAGING</span>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- <section id="tentang" class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 animate__animated animate__fadeInLeft">
                <img src="img/apji1.png" alt="Tentang Kami" class="img-fluid rounded-3">
            </div>
            <div class="col-lg-6 animate__animated animate__fadeInRight">
                <h2 class="fw-bold mb-4">Tentang Kami</h2>
                <p class="lead">Kami adalah wadah bagi para pengusaha kuliner di Jawa Barat untuk berkembang dan berinovasi.</p>
                <h6 class="lead fw-bold">
                    Asosiasi Pengusaha Tataboga Jawa Barat
                </h6>
                <p class="lead mt-4 animate__animated animate__fadeInUp" id="hero-description">
                    Memajukan Industri Kuliner Jawa Barat Melalui Inovasi dan Kolaborasi
                </p>                                      
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Meningkatkan standar kuliner Jawa Barat</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Memfasilitasi pengembangan bisnis anggota</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Mempromosikan kuliner khas Jawa Barat</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Memberikan pelatihan dan sertifikasi</li>
                </ul>
            </div>
        </div>
    </div>
</section> -->

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3">
                <h3>500+</h3>
                <p>Anggota Aktif</p>
            </div>
            <div class="col-md-3">
                <h3>50+</h3>
                <p>Kota/Kabupaten</p>
            </div>
            <div class="col-md-3">
                <h3>100+</h3>
                <p>Program Pelatihan</p>
            </div>
            <div class="col-md-3">
                <h3>1000+</h3>
                <p>Alumni Tersertifikasi</p>
            </div>
        </div>
    </div>
    <!-- <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4 mb-md-0">
                <h2 class="fw-bold">500+</h2>
                <p>Anggota Aktif</p>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <h2 class="fw-bold">50+</h2>
                <p>Kota/Kabupaten</p>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <h2 class="fw-bold">100+</h2>
                <p>Program Pelatihan</p>
            </div>
            <div class="col-md-3">
                <h2 class="fw-bold">1000+</h2>
                <p>Alumni Tersertifikasi</p>
            </div>
        </div>
    </div> -->
</section>

<!-- Services Section -->
<section id="layanan" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 about-title">Layanan Kami</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100 animate__animated animate__fadeInUp">
                    <div class="card-body text-center">
                        <i class="fas fa-graduation-cap service-icon"></i>
                        <h4 class="card-title">Pelatihan Profesional</h4>
                        <p class="card-text">Program pelatihan komprehensif untuk meningkatkan keterampilan kuliner dan manajemen bisnis.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                    <div class="card-body text-center">
                        <i class="fas fa-certificate service-icon"></i>
                        <h4 class="card-title">Sertifikasi</h4>
                        <p class="card-text">Sertifikasi standar kompetensi untuk meningkatkan kredibilitas usaha kuliner Anda.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100 animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
                    <div class="card-body text-center">
                        <i class="fas fa-handshake service-icon"></i>
                        <h4 class="card-title">Konsultasi Bisnis</h4>
                        <p class="card-text">Pendampingan profesional untuk pengembangan dan scaling bisnis kuliner Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Berita -->
<section id="berita" class="py-5 bg-light">
<div class="container">
    <h2 class="text-center fw-bold mb-5 about-title">Berita Terbaru</h2>
    <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <div class="row">
                    <!-- Berita 1 -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <img src="img/berita1.jpg" class="card-img-top" alt="Berita 1">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Judul Berita 1</h5>
                                <p class="card-text">Deskripsi singkat berita 1 yang menarik perhatian pembaca.</p>
                                <a href="#" class="btn btn-primary btn-baca">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- Berita 2 -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <img src="img/berita2.jpg" class="card-img-top" alt="Berita 2">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Judul Berita 2</h5>
                                <p class="card-text">Deskripsi singkat berita 2 yang menarik perhatian pembaca.</p>
                                <a href="#" class="btn btn-primary btn-baca">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- Berita 3 -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <img src="img/berita3.jpg" class="card-img-top" alt="Berita 3">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Judul Berita 3</h5>
                                <p class="card-text">Deskripsi singkat berita 3 yang menarik perhatian pembaca.</p>
                                <a href="#" class="btn btn-primary btn-baca">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="row">
                    <!-- Berita 4 -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <img src="img/berita4.jpg" class="card-img-top" alt="Berita 4">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Judul Berita 4</h5>
                                <p class="card-text">Deskripsi singkat berita 4 yang menarik perhatian pembaca.</p>
                                <a href="#" class="btn btn-primary btn-baca">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- Berita 5 -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <img src="img/berita5.jpg" class="card-img-top" alt="Berita 5">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Judul Berita 5</h5>
                                <p class="card-text">Deskripsi singkat berita 5 yang menarik perhatian pembaca.</p>
                                <a href="#" class="btn btn-primary btn-baca">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- Berita 6 -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <img src="img/berita6.jpg" class="card-img-top" alt="Berita 6">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Judul Berita 6</h5>
                                <p class="card-text">Deskripsi singkat berita 6 yang menarik perhatian pembaca.</p>
                                <a href="#" class="btn btn-primary btn-baca">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kontrol Carousel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>            
    </div>
</div>
</section>

<!-- Contact Section  -->
<section id="kontak" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h2 class="fw-bold about-title">Hubungi Kami</h2>
                    <p class="lead">Jadilah bagian dari komunitas kuliner terbesar di Jawa Barat</p>
                </div>
                <div class="contact-form">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" placeholder="Nama Lengkap">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Nama Usaha">
                        </div>
                        <div class="mb-3">
                            <select class="form-select">
                                <option selected>Pilih Kategori Usaha</option>
                                <option>Restoran</option>
                                <option>Katering</option>
                                <option>Café</option>
                                <option>UMKM Kuliner</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="5" placeholder="Pesan"></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Kirim Pesan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kolom Peta Google Maps Full Width -->
        <div class="col-12">
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126227.29612216696!2d107.610473!3d-6.927213!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6e0e93aafdb%3A0x8a89a3f9c20db5b7!2sJl.%20Asia%20Afrika%20No.141-149%2C%20Lantai%209%2C%20Suite%20901%2C%20Kb.%20Pisang%2C%20Kec.%20Sumur%20Bandung%2C%20Kota%20Bandung%2C%20Jawa%20Barat%2040112!5e0!3m2!1sen!2sid!4v1698381339380!5m2!1sen!2sid" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection