@extends('layout.pemasaran')
@section('content')

<div class="container-fluid">
    <div class="row">
        <x-sidebar-admin />

        <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <h1>Kelayakan Pemasaran</h1>

            <div class="category">
                <form class="search" action="" method="GET">
                    <input type="text" name="search" placeholder="Cari pengajuan" value="">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class='bx bx-search-alt-2'></i> Cari
                    </button>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>Nama Usaha</th>
                            <th>Strategi Pemasaran</th>
                            {{-- <th>Surat Pengantar</th> --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataPemasaran as $data)
                        <tr>
                            <td>{{ $data->nama_usaha }}</td>
                            <td>{{ $data->strategi_pemasaran }}</td>
                            {{-- <td>{{ $data->keahlian_khusus }}</td> --}}
                             <td id="action-{{ $data->id_pemasaran }}">
                                    @if ($data->status === 'diterima')
                                        <button class="btn btn-success btn-lg w-100 disabled">Diterima</button>
                                    @elseif ($data->status === 'ditolak')
                                        <button class="btn btn-danger btn-lg w-100 disabled">Ditolak</button>
                                    @else
                                        <!-- Tombol Terima -->
                                        <a href="#" class="btn btn-success btn-sm accept-btn" data-bs-toggle="modal"
                                            data-bs-target="#acceptModalPemasaran" data-id="{{ $data->id_pemasaran }}">
                                            <i class="bx bx-check-circle"></i>
                                        </a>
                                
                                        <!-- Tombol Tolak -->
                                        <a href="#" class="btn btn-danger btn-sm reject-btn" data-bs-toggle="modal"
                                            data-bs-target="#rejectModalPemasaran" data-id="{{ $data->id_pemasaran }}">
                                            <i class="bx bx-x-circle"></i>
                                        </a>
                                    @endif
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end mt-3">
                    {{ $dataPemasaran->links() }}
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal untuk Lihat Surat Pengantar -->
<div class="modal fade" id="suratPengantarModal" tabindex="-1" aria-labelledby="suratPengantarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="suratPengantarModalLabel">Detail Strategi Pemasaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tampilkan PDF -->
                <embed id="pdfViewer" src="" type="application/pdf" width="100%" height="500px">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Terima -->
<div class="modal fade" id="acceptModalPemasaran" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="acceptModalLabel">Upload File Sertifikat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="acceptForm" method="POST" enctype="multipart/form-data" action="">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File Sertifikat</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>                                                          
            </div>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade" id="rejectModalPemasaran" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Alasan Penolakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="rejectForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="id_detail" id="rejectId">
                    <div class="mb-3">
                        <label for="message" class="form-label">Pesan</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="button" class="btn btn-danger" id="rejectSubmit">Kirim</button>
                </form>                
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Handle modal untuk menampilkan laporan keuangan
    var suratPengantarModal = document.getElementById('suratPengantarModal');
    suratPengantarModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var suratPengantar = button.getAttribute('data-surapengantar');
        var pdfViewer = suratPengantarModal.querySelector('#pdfViewer');
        pdfViewer.src = suratPengantar;
    });

    // Handle modal untuk menerima pengajuan
    var acceptModal = document.getElementById('acceptModalPemasaran');
    acceptModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var form = document.getElementById('acceptForm');
        form.action = "{{ route('updatePemasaran', ':id_pemasaran') }}".replace(':id_pemasaran', id);
    });

    // Handle modal untuk menolak pengajuan
    var rejectModal = document.getElementById('rejectModalPemasaran');
    rejectModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var rejectForm = document.getElementById('rejectForm');
        rejectForm.action = "{{ route('rejectPemasaran', ':id_pemasaran') }}".replace(':id_pemasaran', id);
    });

    // SweetAlert untuk menerima pengajuan
    const acceptForm = document.getElementById('acceptForm');
    if (acceptForm) {
        acceptForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Mencegah pengiriman form langsung
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menerima pengajuan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, terima!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form setelah konfirmasi
                    acceptForm.submit();
                }
            });
        });
    }

    // SweetAlert untuk menolak pengajuan
    const rejectSubmit = document.getElementById('rejectSubmit');
    if (rejectSubmit) {
        rejectSubmit.addEventListener('click', function () {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menolak pengajuan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, tolak!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const rejectForm = document.getElementById('rejectForm');
                    if (rejectForm) {
                        rejectForm.submit();
                    }
                }
            });
        });
    }
</script>
@endsection
