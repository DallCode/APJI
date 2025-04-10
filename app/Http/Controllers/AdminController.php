<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\DataPengguna;
use App\Models\KelayakanFinansial;
use App\Models\KelayakanOperasional;
use App\Models\KelayakanPemasaran;
use App\Models\PengajuanHalal;
use App\Models\PengajuanKoki;
use App\Models\PengajuanAsistenKoki;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard() {
        $recentUsers = User::latest()->paginate(5); // Pagination 5 data per halaman
        $datapengguna = DataPengguna::count();
         // Menghitung total pengajuan dari tiga tabel
        $totalPengajuanHalal = PengajuanHalal::count();
        $totalPengajuanKoki = PengajuanKoki::count();
        $totalPengajuanAsistenKoki = PengajuanAsistenKoki::count();

        $totalKelayakanFinansial = KelayakanFinansial::count();
        $totalKelayakanOperasional = KelayakanOperasional::count();
        $totalKelayakanPemasaran = KelayakanPemasaran::count();

        // Menjumlahkan total pengajuan
        $totalPengajuan = $totalPengajuanHalal + $totalPengajuanKoki + $totalPengajuanAsistenKoki;
        $totalKelayakan = $totalKelayakanFinansial + $totalKelayakanOperasional + $totalKelayakanPemasaran;
        
        return view('admin.dashboard', compact('recentUsers', 'datapengguna', 'totalPengajuan', 'totalKelayakan'));
    }

    public function eventAdmin(Request $request)
    {
        $search = $request->input('search');

        // Menggunakan paginate() untuk mendukung pagination
        $event = Event::when($search, function ($query) use ($search) {
            return $query->where('nama_event', 'LIKE', "%{$search}%");
        })->paginate(10); // Sesuaikan jumlah per halaman (10)

        return view('admin.event', compact('event'));
    }

    public function riwayatAdmin(Request $request)
    {
        $search = $request->input('search'); 
        
        $event = Event::where('tanggal', '<', Carbon::today()) // Hanya event yang sudah kadaluarsa
            ->when($search, function ($query, $search) {
                return $query->where('nama_event', 'like', "%$search%");
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(6); // Batasi 9 event per halaman

        return view('admin.event-riwayat', compact('event'));
    }

    public function detailEvent(Request $request)
    {
        $search = $request->input('search');
        
        $event = Event::where('tanggal', '<', Carbon::today()) // Hanya event yang sudah kadaluarsa
            ->when($search, function ($query, $search) {
                return $query->where('nama_event', 'like', "%$search%");
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(6); // Batasi 9 event per halaman

            return view('admin.detail-event', compact('event'));
        
    }

    
    public function store(Request $request)
    {
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
            $validated['img'] = 'storage/' . $path; // Simpan path untuk akses gambar
        }
    
        // Simpan data ke database
        Event::create($validated);
    
        return redirect()->route('admin.event')->with('success', 'Event created successfully.');
    }
    
    

    public function update(Request $request, $id_event)
    {
        $event = Event::findOrFail($id_event);

        $validated = $request->validate([
            'nama_event' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string',
            'notulensi' => 'nullable|string',
            'dokumentasi' => 'nullable|string',
        ]);

        $event->update([
            'nama_event' => $validated['nama_event'],
            'tanggal' => $validated['tanggal'],
            'lokasi' => $validated['lokasi'],
            'notulensi' => $validated['notulensi'],
            'dokumentasi' => $validated['dokumentasi'],
        ]);

        return redirect()->route('admin.event')->with('success', 'Event updated successfully.');
    }


    public function destroy($id_event)
    {
        $event = Event::findOrFail($id_event);
        $event->delete();

        return redirect()->route('admin.event')->with('success', 'Event deleted successfully.');
    }

    // Show event details
    public function show($id_event)
    {
        $event = Event::findOrFail($id_event);
        return response()->json($event);
    }
}