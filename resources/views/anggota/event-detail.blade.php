@extends('layout.event-detail')
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
                <h1 class="fw-bold text-black">Riwayat Event</h1>
                <p class="text-dark">Lihat kembali event-event APJI yang telah terlewatkan sebelumnya.</p>
            </div>

            <!-- Search Section -->
            <div class="container pt-4">
                <form class="d-flex" role="search" method="GET" action="{{ route('riwayat') }}">
                    <input class="form-control me-2" type="search" name="search" value="{{ request('search') }}" placeholder="Cari Riwayat Event" aria-label="Search">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </form>
            </div>

            <!-- Riwayat Events Table -->
            <div class="container pt-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Event</th>
                                <th>Tanggal</th>
                                <th>Notulensi</th>
                                {{-- <th>Lokasi</th> --}}
                                {{-- <th>Gambar</th> --}}
                            <th>Dokumentasi</th>
                                {{-- <th>Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($event as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->nama_event }}</td>
                                <td class="text-center">{{ $item->tanggal }}</td>
                                <td>{{ $item->notulensi }}</td>
                                {{-- <td>{{ $item->lokasi }}</td> --}}
                                {{-- <td class="text-center">
                                    <img src="{{ asset($item->img) }}" alt="{{ $item->nama_event }}" class="rounded" style="width: 100px; height: 60px; object-fit: cover;">
                                </td> --}}
                                <td class="text-center">
                                    <a href="{{ $item->dokumentasi }}" class="btn btn-info btn-sm" target="_blank">Lihat</a>
                                </td>
                                {{-- <td class="text-center">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#eventDetailModal{{ $item->id }}">Detail</button>
                                </td> --}}
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada event tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Section -->
            <div class="container pt-4">
                @if ($event->total() > 6)
                    <div class="d-flex justify-content-end">
                        {{ $event->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
