@extends('layout.detail-event')
@section('content')

<div class="container-fluid">
    <div class="row">

        <x-sidebar-admin/>

        <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <h1>Riwayat Event</h1>

            <div class="category">
                {{-- <a class="add-new" href="" data-bs-toggle="modal" data-bs-target="#createEventModal">Add New</a> --}}

                <form class="search" action="" method="GET">
                    <input type="text" name="search" placeholder="Cari event" value="">
                    <button type="submit"><i class='bx bx-search-alt-2'></i>Cari</button>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Notulensi</th>
                            <th>Dokumentasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event as $event)
                            <tr>
                                <td>{{ $event->nama_event }}</td>
                                <td>
                                    <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#viewNotulensiModal{{ $event->id_event }}">
                                        <i class='bx bxs-pencil'></i>
                                    </a>
                                </td>
                                <td>
                                    @if($event->dokumentasi)
                                        <a href="{{ $event->dokumentasi }}" target="_blank" class="btn btn-success w-100 text-center">
                                            <i class='bx bx-link'></i> Lihat Dokumentasi
                                        </a>
                                    @else
                                        <p class="text-muted">Tidak ada dokumentasi tersedia.</p>
                                    @endif
                                </td>
                            </tr>

                            <!-- Notulensi Modal -->
                            <div class="modal fade" id="viewNotulensiModal{{ $event->id_event }}" tabindex="-1" aria-labelledby="viewNotulensiLabel{{ $event->id_event }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Notulensi {{ $event->nama_event }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if($event->notulensi)
                                                <p>{{ $event->notulensi }}</p>
                                            @else
                                                <p class="text-muted">Tidak ada notulensi tersedia.</p>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>

                {{-- <div class="d-flex justify-content-center">
                    {{ $event->links() }}
                </div> --}}
            </div>

        </main>
    </div>
</div>
@endsection
