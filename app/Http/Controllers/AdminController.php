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


class AdminController extends Controller
{
    public function dashboard() {
        $recentUsers = User::latest()->take(5)->get(); 
        $datapengguna = DataPengguna::count();
        $keanggotaan = DataPengguna::where('tipe_member', 'Terdaftar')->count();
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
        
        return view('admin.dashboard', compact('recentUsers', 'datapengguna', 'keanggotaan', 'totalPengajuan', 'totalKelayakan'));
    }

    public function event(Request $request)
    {
        $search = $request->input('search');

        // Menggunakan paginate() untuk mendukung pagination
        $event = Event::when($search, function ($query) use ($search) {
            return $query->where('nama_event', 'LIKE', "%{$search}%");
        })->paginate(10); // Sesuaikan jumlah per halaman (10)

        return view('admin.event', compact('event'));
    }

    public function riwayat()
    {
        $event = Event::all();

        return view('admin.event-riwayat', compact('event'));
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
            'daftar_hadir' => 'nullable|string',
            'notulensi' => 'nullable|string',
            'dokumentasi' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('dokumentasi')) {
            $image = $request->file('dokumentasi');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imageData = file_get_contents($image->getRealPath());
            $event->dokumentasi = base64_encode($imageData);
        }
        // if ($request->hasFile('dokumentasi')) {
        //     $path = $request->file('dokumentasi')->store('events', 'public');
        //     $event->dokumentasi = 'storage/' . $path;
        // }
        

        $event->update([
            'nama_event' => $validated['nama_event'],
            'tanggal' => $validated['tanggal'],
            'lokasi' => $validated['lokasi'],
            'daftar_hadir' => $validated['daftar_hadir'],
            'notulensi' => $validated['notulensi'],
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
