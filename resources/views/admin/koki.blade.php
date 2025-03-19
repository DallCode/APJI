@extends('layout.koki')
@section('content')

<div class="container-fluid">
    <div class="row">
        <x-sidebar-admin/>

        <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <h1>Sertifikasi Koki</h1>

            <div class="category">
                <form class="search" action="" method="GET">
                    <input type="text" name="search" placeholder="Cari pengajuan halal" value="">
                    <button type="submit"><i class='bx bx-search-alt-2'></i>Cari</button>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Pengalaman Kerja</th>
                            <th>Pendidikan Terakhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kokiData as $data)
                            <tr>
                                <td>{{ $data->nama_lengkap }}</td>
                                <td>{{ $data->pengalaman_kerja }}</td>
                                <td>{{ $data->pendidikan_terakhir }}</td>
                                <td id="action-{{ $data->id_detail }}">
                                    @if ($data->status === 'diterima')
                                        <button class="btn btn-success btn-lg w-100 disabled">Diterima</button>
                                    @elseif ($data->status === 'ditolak')
                                        <button class="btn btn-danger btn-lg w-100 disabled">Ditolak</button>
                                    @else
                                        <!-- Tombol Terima -->
                                        <a href="#" class="btn btn-success btn-sm accept-btn" data-bs-toggle="modal"
                                            data-bs-target="#acceptModalKoki" data-id="{{ $data->id_detail }}">
                                            <i class="bx bx-check-circle"></i>
                                        </a>
                                
                                        <!-- Tombol Tolak -->
                                        <a href="#" class="btn btn-danger btn-sm reject-btn" data-bs-toggle="modal"
                                            data-bs-target="#rejectModalKoki" data-id="{{ $data->id_detail }}">
                                            <i class="bx bx-x-circle"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-right mt-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            @if ($kokiData->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $kokiData->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo; Previous</span>
                                    </a>
                                </li>
                            @endif
                
                            @foreach ($kokiData->getUrlRange(1, $kokiData->lastPage()) as $page => $url)
                                <li class="page-item {{ $kokiData->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                
                            @if ($kokiData->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $kokiData->nextPageUrl() }}" aria-label="Next">
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

<!-- Modal Pengalaman Kerja -->
<div class="modal fade" id="pengalamanModal" tabindex="-1" aria-labelledby="pengalamanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pengalamanModalLabel">Detail Pengalaman Kerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalpengalaman"></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Terima -->
<div class="modal fade" id="acceptModalKoki" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true">
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
                    <button type="submit" class="btn btn-primary" id="acceptSubmit">Kirim</button>
                </form>                                            
            </div>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade" id="rejectModalKoki" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
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
    // Handle modal for accepting request
    var acceptModal = document.getElementById('acceptModalKoki');
    acceptModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var form = document.getElementById('acceptForm');
        form.action = "{{ route('updateKoki', ':id_detail') }}".replace(':id_detail', id);
    });

    // Handle modal for rejecting request
    var rejectModal = document.getElementById('rejectModalKoki');
    rejectModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var form = document.getElementById('rejectForm');
        form.action = "{{ route('rejectKoki', ':id_detail') }}".replace(':id_detail', id);
    });

    // SweetAlert for accepting
    document.getElementById('acceptForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Mencegah pengiriman form langsung

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan menerima pengajuan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, lanjutkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form setelah konfirmasi
                document.getElementById('acceptForm').submit();
            }
        });
    });

    // SweetAlert for rejecting
    document.getElementById('rejectSubmit').addEventListener('click', function () {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan menolak pengajuan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, lanjutkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('rejectForm').submit();
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.querySelector("table");
        const headers = table.querySelectorAll("th");
        const tbody = table.querySelector("tbody");

        const sortTable = (index, asc) => {
            const rows = Array.from(tbody.querySelectorAll("tr"));
            
            rows.sort((rowA, rowB) => {
                const cellA = rowA.children[index].textContent.trim().toLowerCase();
                const cellB = rowB.children[index].textContent.trim().toLowerCase();
                
                if (!isNaN(Date.parse(cellA)) && !isNaN(Date.parse(cellB))) {
                    return asc ? new Date(cellA) - new Date(cellB) : new Date(cellB) - new Date(cellA);
                }
                
                return asc ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
            });
            
            rows.forEach(row => tbody.appendChild(row));
        };

        headers.forEach((header, index) => {
            let asc = true;
            header.addEventListener("click", () => {
                sortTable(index, asc);
                asc = !asc;
            });
        });
    });
</script>


@endsection