<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DataPengguna;
use App\Models\PengajuanHalal;
use App\Models\PengajuanKoki;
use App\Models\PengajuanAsistenKoki;
use App\Models\KelayakanFinansial;
use App\Models\KelayakanOperasional;
use App\Models\KelayakanPemasaran;
use App\Models\Event;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Menampilkan dashboard admin
    public function dashboard() {
        // Mengambil data pengguna terbaru dengan pagination
        $recentUsers = User::latest()->paginate(5);
        
        // Menghitung jumlah total pengguna
        $datapengguna = DataPengguna::count();
        
        // Menghitung jumlah pengguna yang berstatus 'Terdaftar'
        // $keanggotaan = DataPengguna::where('tipe_member', 'Terdaftar')->count();

         // Mengambil event terbaru yang belum kadaluarsa (tanggal_akhir belum lewat hari ini)
        $eventTerbaru = Event::where('tanggal', '>=', now())->latest('tanggal')->first();
        
        // Menghitung total pengajuan dari berbagai tabel
        $totalPengajuan = PengajuanHalal::count() + PengajuanKoki::count() + PengajuanAsistenKoki::count();
        
        // Menghitung total kelayakan dari berbagai tabel
        $totalKelayakan = KelayakanFinansial::count() + KelayakanOperasional::count() + KelayakanPemasaran::count();

        return view('admin.dashboard', compact('recentUsers', 'datapengguna', 'totalPengajuan', 'totalKelayakan', 'eventTerbaru'));
    }

    // Menampilkan daftar event dengan fitur pencarian
    public function eventAdmin(Request $request) {
        $search = $request->input('search');

        $event = Event::when($search, function ($query) use ($search) {
            return $query->where('nama_event', 'LIKE', "%{$search}%");
        })->paginate(10);

        return view('admin.event', compact('event'));
    }

    // Menampilkan riwayat event yang sudah kadaluarsa
    public function riwayatAdmin(Request $request) {
        $search = $request->input('search'); 

        $event = Event::where('tanggal', '<', Carbon::today())
            ->when($search, function ($query, $search) {
                return $query->where('nama_event', 'like', "%$search%");
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(6);

        return view('admin.event-riwayat', compact('event'));
    }

    // Menampilkan detail event
    public function detailEvent(Request $request) {
        $search = $request->input('search');
        
        $event = Event::where('tanggal', '<', Carbon::today())
            ->when($search, function ($query, $search) {
                return $query->where('nama_event', 'like', "%$search%");
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(6);

        return view('admin.detail-event', compact('event'));
    }

    // Menyimpan event baru
    public function store(Request $request) {
        $validated = $request->validate([
            'nama_event' => 'required|string',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string',
        ]);

        // Upload gambar ke storage
        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('events', 'public');
            $validated['img'] = 'storage/' . $path;
        }

        // Menyimpan data event ke database
        Event::create($validated);

        return redirect()->route('admin.event')->with('success', 'Event created successfully.');
    }

    // Memperbarui data event
    public function update(Request $request, $id_event) {
        $event = Event::findOrFail($id_event);

        $validated = $request->validate([
            'nama_event' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string',
            'notulensi' => 'nullable|string',
            'dokumentasi' => 'nullable|string',
        ]);

        // Memperbarui data event
        $event->update($validated);

        return redirect()->route('admin.event')->with('success', 'Event updated successfully.');
    }

    // Menghapus event berdasarkan ID
    public function destroy($id_event) {
        $event = Event::findOrFail($id_event);
        $event->delete();

        return redirect()->route('admin.event')->with('success', 'Event deleted successfully.');
    }

    // Menampilkan detail event dalam format JSON
    public function show($id_event) {
        $event = Event::findOrFail($id_event);
        return response()->json($event);
    }
}
