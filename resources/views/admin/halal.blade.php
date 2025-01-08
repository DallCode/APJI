@extends('layout.halal')
@section('content')
<div class="container-fluid">
    <div class="row">
        <x-sidebar-admin/>

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
                            <tr>
                                <td>{{ $data->nama_usaha }}</td>
                                <td class="alamat-column">
                                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addressModal" data-address="{{ $data->alamat_usaha }}">
                                        <i class="bx bx-show"></i>
                                    </a>
                                </td>                                                               
                                <td>{{ $data->jenis_usaha }}</td>
                                <td>{{ $data->nama_produk }}</td>
                                <td>
                                    <!-- Tombol Terima -->
                                    <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#acceptModal" data-id="{{ $data->id_detail }}">
                                        <i class="bx bx-check-circle"></i>
                                    </a>

                                    <!-- Tombol Tolak -->
                                    <a href="#" class="btn btn-danger btn-sm" onclick="handleReject({{ $data->id_detail }})">
                                        <i class="bx bx-x-circle"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<!-- Modal Alamat Usaha -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Detail Alamat Usaha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalAddress"></p>
            </div>
        </div>
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
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_detail" id="acceptId">
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File Sertifikat</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle modal for accepting request
    var acceptModal = document.getElementById('acceptModal');
    acceptModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var inputId = acceptModal.querySelector('#acceptId');
        inputId.value = id;
    });

    // Handle modal for showing address
    var addressModal = document.getElementById('addressModal');
    addressModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var address = button.getAttribute('data-address');
        var modalAddress = addressModal.querySelector('#modalAddress');
        modalAddress.textContent = address;
    });

    // Handle reject action
    function handleReject(id) {
        if (confirm('Apakah Anda yakin ingin menolak pengajuan ini?')) {
            // Kirim permintaan tolak ke server
            fetch(`/sertifikasi/reject/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Pengajuan berhasil ditolak.');
                    location.reload();
                } else {
                    alert('Gagal menolak pengajuan.');
                }
            });
        }
    }
</script>
@endsection
