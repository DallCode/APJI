@extends('layout.halal')
@section('content')

<div class="container-fluid">
    <div class="row">
        <x-sidebar-admin />

        <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <h1>Sertifikasi Halal</h1>

            <div class="category">
                <form class="search" action="" method="GET">
                    <input type="text" name="search" placeholder="Cari pengajuan halal" value="">
                    <button type="submit"><i class='bx bx-search-alt-2'></i>Cari</button>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>Nama Usaha</th>
                            <th>Alamat Usaha</th>
                            <th>Jenis Usaha</th>
                            <th>Nama Produk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($halalData as $data)
                            <tr id="row-{{ $data->id_detail }}">
                                <td>{{ $data->nama_usaha }}</td>
                                <td>{{ $data->alamat_usaha }}</td>
                                <td>{{ $data->jenis_usaha }}</td>
                                <td>{{ $data->nama_produk }}</td>
                                <td id="action-{{ $data->id_detail }}">
                                    @if ($data->status === 'diterima')
                                        <button class="btn btn-success btn-lg w-100 disabled">Diterima</button>
                                    @elseif ($data->status === 'ditolak')
                                        <button class="btn btn-danger btn-lg w-100 disabled">Ditolak</button>
                                    @else
                                        <!-- Tombol Terima -->
                                        <a href="#" class="btn btn-success btn-sm accept-btn" data-bs-toggle="modal"
                                            data-bs-target="#acceptModal" data-id="{{ $data->id_detail }}">
                                            <i class="bx bx-check-circle"></i>
                                        </a>
                                
                                        <!-- Tombol Tolak -->
                                        <a href="#" class="btn btn-danger btn-sm reject-btn" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal" data-id="{{ $data->id_detail }}">
                                            <i class="bx bx-x-circle"></i>
                                        </a>
                                    @endif
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-left mt-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            @if ($halalData->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $halalData->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo; Previous</span>
                                    </a>
                                </li>
                            @endif
                
                            @foreach ($halalData->getUrlRange(1, $halalData->lastPage()) as $page => $url)
                                <li class="page-item {{ $halalData->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                
                            @if ($halalData->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $halalData->nextPageUrl() }}" aria-label="Next">
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

<!-- Modal Terima -->
<div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="acceptModalLabel">Upload File Sertifikat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="acceptForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_detail" id="acceptId">
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
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Alasan Penolakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="rejectForm" method="POST">
                    @csrf
                    <input type="hidden" name="id_detail" id="rejectId">
                    <div class="mb-3">
                        <label for="message" class="form-label">Pesan</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Modal Tolak -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Alasan Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="rejectForm" method="POST" action="{{ route('rejectHalal', ':id_detail') }}">
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
        var acceptModal = document.getElementById('acceptModal');
        acceptModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var form = document.getElementById('acceptForm');
            form.action = "{{ route('updateHalal', ':id') }}".replace(':id', id);
        });



        // Handle modal for rejecting request
        var rejectModal = document.getElementById('rejectModal');
        rejectModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var form = document.getElementById('rejectForm');
            form.action = "{{ route('rejectHalal', ':id_detail') }}".replace(':id_detail', id);
        });

        // SweetAlert for accepting
        document.getElementById('acceptForm').addEventListener('submit', function(event) {
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
        document.getElementById('rejectSubmit').addEventListener('click', function() {
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
        document.querySelectorAll(".accept-btn").forEach(button => {
            button.addEventListener("click", function () {
                let id = this.getAttribute("data-id");
                updateStatus(id, "diterima");
            });
        });

        document.querySelectorAll(".reject-btn").forEach(button => {
            button.addEventListener("click", function () {
                let id = this.getAttribute("data-id");
                updateStatus(id, "ditolak");
            });
        });

        function updateStatus(id, status) {
            fetch(`/halal/${id}/update-status`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let actionCell = document.getElementById(`action-${id}`);
                    
                    if (status === "diterima") {
                        actionCell.innerHTML = `<button class="btn btn-success btn-lg w-100 disabled">Diterima</button>`;
                    } else {
                        actionCell.innerHTML = `<button class="btn btn-danger btn-lg w-100 disabled">Ditolak</button>`;
                    }
                }
            })
            .catch(error => console.error("Error:", error));
        }
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