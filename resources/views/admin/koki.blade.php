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
                                <td class="pengalaman-column">
                                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pengalamanModal" data-pengalaman="{{ $data->pengalaman_kerja }}">
                                        <i class="bx bx-show"></i>
                                    </a>
                                </td>                                
                                <td>{{ $data->pendidikan_terakhir }}</td>
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

    // Handle modal for pengalaman kerja
    var pengalamanModal = document.getElementById('pengalamanModal');
    pengalamanModal.addEventListener('show.bs.modal', function (event) {
        // Ambil tombol yang memicu modal
        var button = event.relatedTarget;
        // Ambil data-pengalaman dari tombol
        var pengalaman = button.getAttribute('data-pengalaman');
        // Dapatkan elemen modal untuk menampilkan data
        var modalBody = pengalamanModal.querySelector('.modal-body p');
        // Tampilkan data pengalaman kerja di dalam modal
        modalBody.textContent = pengalaman;
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
