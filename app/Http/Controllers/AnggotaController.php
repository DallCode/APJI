<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function event()
    {
        $event = Event::all(); // Ambil semua data event dari tabel
        return view('anggota.event-anggota', compact('event'));
    }

    public function riwayat()
    {
        return view('anggota.riwayat-event');
    }

    public function pengajuan()
    {
        return view('anggota.pengajuan-sertifikat');
    }

    public function dashboard()
    {
        $Event = Event::all(); // Ambil semua data event dari tabel
        return view('anggota.dashboard-anggota', compact('Event'));
    }

    public function kelayakanUsaha()
    {
        return view('anggota.kelayakan-usaha');
    }
}
