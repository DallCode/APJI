<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnggotaController extends Controller
{
    /**
     * Menampilkan daftar event yang masih akan berlangsung atau yang akan datang.
     * Bisa melakukan pencarian event berdasarkan nama.
     */
    public function event(Request $request)
    {
        // Mengambil input pencarian dari request
        $search = $request->input('search');

        // Mengambil event yang masih akan berlangsung (tanggal lebih besar atau sama dengan hari ini)
        $event = Event::where('tanggal', '>=', Carbon::today())
            ->when($search, function ($query) use ($search) {
                // Jika ada pencarian, filter event berdasarkan nama yang mengandung kata kunci pencarian
                return $query->where('nama_event', 'like', "%$search%")
                             ->where('tanggal', '>=', Carbon::today()); // Tambahkan filter ulang agar tetap dalam rentang tanggal
            })
            ->paginate(6) // Menampilkan 6 event per halaman
            ->appends(request()->query()); // Menyertakan query pencarian saat paginasi

        // Menampilkan halaman event dengan data event yang sudah difilter
        return view('anggota.event-anggota', compact('event', 'search'));
    }

    /**
     * Menampilkan riwayat event (event yang sudah berlalu).
     * Bisa melakukan pencarian berdasarkan nama event.
     */
    public function riwayat(Request $request)
    {
        // Mengambil input pencarian dari request
        $search = $request->input('search');

        // Mengambil event yang sudah berlalu (tanggal lebih kecil dari hari ini)
        $event = Event::where('tanggal', '<', Carbon::today())
            ->when($search, function ($query) use ($search) {
                // Jika ada pencarian, filter event berdasarkan nama
                return $query->where('nama_event', 'like', "%$search%");
            })
            ->orderByDesc('tanggal') // Mengurutkan event dari yang terbaru ke yang lama
            ->paginate(6) // Menampilkan 6 event per halaman
            ->appends(request()->query()); // Menyertakan query pencarian saat paginasi

        // Menampilkan halaman riwayat event
        return view('anggota.riwayat-event', compact('event', 'search'));
    }

    /**
     * Menampilkan detail event dengan fitur pencarian.
     */
    public function Detail(Request $request)
    {
        // Mengambil input pencarian dari request
        $search = $request->input('search');

        // Mengambil event dengan fitur pencarian berdasarkan nama event
        $event = Event::when($search, function ($query) use ($search) {
            return $query->where('nama_event', 'LIKE', "%{$search}%");
        })->paginate(10); // Menampilkan 10 event per halaman

        // Menampilkan halaman detail event
        return view('anggota.event-detail', compact('event'));
    }

    /**
     * Menampilkan halaman pengajuan sertifikat.
     */
    public function pengajuan()
    {
        return view('anggota.pengajuan-sertifikat');
    }

    /**
     * Menampilkan dashboard anggota dengan 3 event terbaru berdasarkan tanggal.
     */
    public function dashboard()
    {
        // Mengambil 3 event terbaru berdasarkan tanggal
        $Event = Event::orderBy('tanggal', 'desc')->take(3)->get();

        // Menampilkan halaman dashboard anggota dengan event terbaru
        return view('anggota.dashboard-anggota', compact('Event'));
    }

    /**
     * Menampilkan halaman kelayakan usaha.
     */
    public function kelayakanUsaha()
    {
        return view('anggota.kelayakan-usaha');
    }
}
