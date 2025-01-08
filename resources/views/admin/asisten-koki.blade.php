@extends('layout.asisten-koki')
@section('content')
<div class="container-fluid">
    <div class="row">
        <x-sidebar-admin />

        <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <h1>Sertifikasi Asisten Koki</h1>

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
                            <th>Nama Lengkap</th>
                            <th>Keahlian Khusus</th>
                            <th>Surat Pengantar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($asistenData as $data)
                        <tr>
                            <td>{{ $data->nama_lengkap }}</td>
                            <td>{{ $data->keahlian_khusus }}</td>
                            <td class="surat-pengantar-column">
                                <!-- Tombol Lihat Surat Pengantar -->
                                @if($data->surat_pengantar)
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#suratPengantarModal" 
                                        data-surapengantar="{{ Storage::url($data->surat_pengantar) }}">
                                    <i class='bx bx-show'></i>
                                </button>
                                @else
                                <span>Tidak Ada</span>
                                @endif
                            </td>
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

<!-- Modal untuk Lihat Surat Pengantar -->
<div class="modal fade" id="suratPengantarModal" tabindex="-1" aria-labelledby="suratPengantarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="suratPengantarModalLabel">Surat Pengantar</h5>
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

<script>
    // Handle modal untuk menampilkan surat pengantar
    var suratPengantarModal = document.getElementById('suratPengantarModal');
    suratPengantarModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var suratPengantar = button.getAttribute('data-surapengantar');
        var pdfViewer = suratPengantarModal.querySelector('#pdfViewer');
        pdfViewer.src = suratPengantar;
    });

    // Handle aksi tolak
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
