@extends('layout.guide-user')

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
                <h1 class="fw-bold text-black">Bantuan</h1>
                <p class="text-dark">Informasi Terkait Penggunaan Aplikasi, FAQ.</p>
            </div>
            
            <!-- Workflow Container -->
            <div class="workflow-container p-4">
                <h2 class="workflow-title border-bottom pb-2 mb-4">Alur Kerja Sistem</h2>
                
                <!-- Workflow Overview Section as Accordion -->
                <div class="accordion" id="workflowAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                1. Dashboard
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#workflowAccordion">
                            <div class="accordion-body">
                                Setelah login berhasil, pengguna diarahkan ke halaman dashboard yang menampilkan informasi relevan seperti ringkasan aktivitas, notifikasi, dan akses cepat ke fitur-fitur utama.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                2. Event
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#workflowAccordion">
                            <div class="accordion-body">
                                Pengguna dapat melihat dan mengakses event yang sedang berlangsung, termasuk informasi detail seperti tanggal, waktu, dan lokasi termasuk riwayat event yang sudah kadaluarsa.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                3. Pengajuan Sertifikat
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#workflowAccordion">
                            <div class="accordion-body">
                                Pengguna dapat melakukan permohonan pengajuan Sertifikat Halal, Koki, dan Asisten Koki dengan mengisi form yang telah disediakan sesuai ketentuan, setelah melakukan pengajuan, pengguna diminta untuk menunggu proses pengajuan dan sistem akan meninjau permohonan.
                        </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                4. Pengajuan Usaha
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#workflowAccordion">
                            <div class="accordion-body">
                                Pengguna dapat melakukan permohonan pengajuan Kelayakan Usaha, mencakup Kelayakan Finansial, Kelayakan Operasional, dan Kelayakan Pemasaran dengan mengisi form yang telah disediakan sesuai ketentuan, setelah melakukan pengajuan, pengguna diminta untuk menunggu proses pengajuan dan sistem akan meninjau permohonan.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                5. Persetujuan
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#workflowAccordion">
                            <div class="accordion-body">
                                Pengajuan akan ditinjau oleh Instansi terkait. Mereka dapat menyetujui, menolak, atau meminta revisi dengan memberikan komentar.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                6. Profile
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#workflowAccordion">
                            <div class="accordion-body">
                                Pengguna dapat melihat, mengedit, dan menambahkan informasi data diri pada halaman ini.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="faq-section mt-5">
                    <h2 class="border-bottom pb-2 mb-4">FAQ - Pertanyaan Umum</h2>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeadingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseOne" aria-expanded="true" aria-controls="faqCollapseOne">
                                    Bagaimana jika pengajuan saya ditolak?
                                </button>
                            </h2>
                            <div id="faqCollapseOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Klik tombol "Ditolak" lihat pesan dari admin, lalu klik tombol "Ajukan ulang" dan isi form sesuai dengan ketentuan.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeadingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
                                    Bagaimana cara melihat status pengajuan saya?
                                </button>
                            </h2>
                            <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Pergi ke menu "Pengajuan Sertifikat" atau "Kelayakan Usaha", status akan ditampilkan pada tombol detail.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
