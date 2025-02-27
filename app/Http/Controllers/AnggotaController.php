<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnggotaController extends Controller
{
    public function event(Request $request)
    {
        $search = $request->input('search');
        $event = Event::where('tanggal', '>=', Carbon::today())
        ->when($search, function ($query) use ($search) {
            return $query->where('nama_event', 'like', "%$search%")
                         ->where('tanggal', '>=', Carbon::today()); // Tambahkan filter ulang
        })
        ->paginate(6)
        ->appends(request()->query());

        return view('anggota.event-anggota', compact('event', 'search'));
    }

    public function riwayat(Request $request)
    {
        $search = $request->input('search');

        $event = Event::where('tanggal', '<', Carbon::today())
                    ->when($search, function ($query) use ($search) {
                        return $query->where('nama_event', 'like', "%$search%");
                    })
                    ->orderByDesc('tanggal') // Urutkan dari yang terbaru
                    ->paginate(6) // Batasi 6 event per halaman
                    ->appends(request()->query()); // Menjaga query pencarian saat paginasi

        return view('anggota.riwayat-event', compact('event', 'search'));
    }

    public function pengajuan()
    {
        return view('anggota.pengajuan-sertifikat');
    }

    public function dashboard()
    {
        $Event = Event::orderBy('tanggal', 'desc')->take(3)->get();
        return view('anggota.dashboard-anggota', compact('Event'));
    }

    public function kelayakanUsaha()
    {
        return view('anggota.kelayakan-usaha');
    }
}
