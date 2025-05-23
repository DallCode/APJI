<?php

namespace App\Http\Controllers;

use App\Models\KelayakanFinansial;
use App\Models\KelayakanOperasional;
use App\Models\KelayakanPemasaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class KelayakanUsahaController extends Controller
{
    public function storeFinansial(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'laporan_keuangan' => 'required|file|mimes:pdf,docx',
            'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // Validasi file
        ]);
        // $request->all();

         // Simpan file jika ada
         $filePath = null;
         if ($request->hasFile('file')) {
             $filePath = $request->file('file')->store('kelayakan_finansial', 'public'); // Simpan di storage/public/pengajuan_halal
         }

        $path = $request->file('laporan_keuangan')->store('laporan_keuangan', 'public');
        

        KelayakanFinansial::create([
            'id_pengguna' => auth()->user()->dataPengguna->id_pengguna, // Gunakan ID user yang sedang login
            'nama_usaha' => $request->nama_usaha,
            'laporan_keuangan' => $path,
            'file' => $filePath, // Path file atau null jika tidak ada 
            'status' => 'menunggu',
        ]);

        return redirect()->route('kelayakanUsaha')->with('success', 'Pengajuan Kelayakan Finansial berhasil diajukan.');
        // return redirect()->back()->with('success', 'Pengajuan Kelayakan Finansial berhasil diajukan.');
    }

    public function updateUserFinansial(Request $request, $id_finansial)
    {
        // Debugging
        // dd($request->all(), $id_finansial);

        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'laporan_keuangan' => 'required|file|mimes:pdf,docx',
        ]);

        $kelayakanFinansial = KelayakanFinansial::findOrFail($id_finansial);

        if ($request->hasFile('laporan_keuangan')) {
            $filePath = $request->file('laporan_keuangan')->store('laporan_keuangan', 'public');
            $kelayakanFinansial->laporan_keuangan = $filePath;
        }

        $kelayakanFinansial->nama_usaha = $request->nama_usaha;
        $kelayakanFinansial->status = "menunggu";
        $kelayakanFinansial->save();

        return redirect()->route('kelayakanUsaha', ['id_finansial' => $id_finansial])->with('success', 'Pengajuan berhasil.');
    }

    public function updateFinansial(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,png|max:2048', // Validasi file wajib ada
        ]);

         // Temukan data pengajuan berdasarkan ID
         $kelayakanFinansial = KelayakanFinansial::findOrFail($id);

         // Simpan file baru
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('kelayakan_finansial', 'public');
            $kelayakanFinansial->file = $filePath; // Update path file
        }

        // Update status menjadi 'diterima'
        $kelayakanFinansial->status = 'diterima';
        $kelayakanFinansial->save(); // Simpan perubahan

        return redirect()->route('finansial')->with('success', 'Pengajuan diterima dan sertifikat berhasil diupload.');
    }

    public function rejectFinansial(Request $request, $id)
    {
        // return $request;
        // Validasi input
        $request->validate([
            'message' => 'required|string|max:1000', // Pesan harus diisi
        ]);
        // dd($request->all()); // Debug data request

        // Temukan data pengajuan berdasarkan ID
        $kelayakanFinansial = KelayakanFinansial::findOrFail($id);

         // Simpan pesan ke public storage
         $fileName = 'rejection_message_' . $id . '.txt';
         $filePath = 'kelayakan_finansial_rejections/' . $fileName;
        \Storage::disk('public')->put($filePath, $request->message);

          // Update status menjadi 'ditolak'
        $kelayakanFinansial->status = 'ditolak';
        $kelayakanFinansial->file = $filePath; // Simpan path pesan ke kolom file
        $kelayakanFinansial->save();

        return redirect()->route('finansial')->with('success', 'Pengajuan berhasil ditolak.');
    }
    
    public function storeOperasional(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'deskripsi_operasional' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // Validasi file
        ]);

        // Simpan file jika ada
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('kelayakan_operasional', 'public'); // Simpan di storage/public/pengajuan_halal
        }

        KelayakanOperasional::create([
            'id_pengguna' => auth()->user()->dataPengguna->id_pengguna, // Gunakan ID user yang sedang login
            'nama_usaha' => $request->nama_usaha,
            'deskripsi_operasional' => $request->deskripsi_operasional, 
            'file' => $filePath, // Path file atau null jika tidak ada 
            'status' => 'menunggu',
        ]);
        
        // KelayakanOperasional::create($request->all());
        
        return redirect()->route('kelayakanUsaha')->with('success', 'Pengajuan Kelayakan Operasional berhasil diajukan.');
        // return redirect()->back()->with('success', 'Pengajuan Kelayakan Operasional berhasil diajukan.');
    }

    public function updateUserOperasional(Request $request, $id_operasional)
    {
        // Debugging
        // dd($request->all(), $id_operasional);

        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'deskripsi_operasional' => 'required|string',
        ]);

        $kelayakanOperasional = KelayakanOperasional::findOrFail($id_operasional);

        $kelayakanOperasional->nama_usaha = $request->nama_usaha;
        $kelayakanOperasional->deskripsi_operasional = $request->deskripsi_operasional;
        $kelayakanOperasional->status = "menunggu";
        $kelayakanOperasional->save();

        return redirect()->route('kelayakanUsaha', ['id_operasional' => $id_operasional])->with('success', 'Pengajuan berhasil.');
    }

    public function updateOperasional (Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,png|max:2048', // Validasi file wajib ada
        ]);

        // Temukan data pengajuan berdasarkan ID
        $kelayakanOperasional = KelayakanOperasional::findOrFail($id);

        // Simpan file baru
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('kelayakan_operasional', 'public');
            $kelayakanOperasional->file = $filePath; // Update path file
        }

         // Update status menjadi 'diterima'
         $kelayakanOperasional->status = 'diterima';
         $kelayakanOperasional->save(); // Simpan perubahan
 
         return redirect()->route('operasional')->with('success', 'Pengajuan diterima dan sertifikat berhasil diupload.');
    }

    public function rejectOperasional(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'message' => 'required|string|max:1000', // Pesan harus diisi
        ]);

        // Temukan data pengajuan berdasarkan ID
        $kelayakanOperasional = KelayakanOperasional::findOrFail($id);

        // Simpan pesan ke public storage
        $fileName = 'rejection_message_' . $id . '.txt';
        $filePath = 'kelayakan_operasional_rejections/' . $fileName;
       \Storage::disk('public')->put($filePath, $request->message);

          // Update status menjadi 'ditolak'
          $kelayakanOperasional->status = 'ditolak';
          $kelayakanOperasional->file = $filePath; // Simpan path pesan ke kolom file
          $kelayakanOperasional->save();
  
          return redirect()->route('operasional')->with('success', 'Pengajuan berhasil ditolak.');
    }
    
    public function storePemasaran(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'strategi_pemasaran' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // Validasi file
        ]);

         // Simpan file jika ada
         $filePath = null;
         if ($request->hasFile('file')) {
             $filePath = $request->file('file')->store('kelayakan_pemasaran', 'public'); // Simpan di storage/public/pengajuan_halal
         }
        
        // $path = $request->file('strategi_pemasaran')->store('strategi_pemasaran');
        
        KelayakanPemasaran::create([
            'id_pengguna' => auth()->user()->dataPengguna->id_pengguna, // Gunakan ID user yang sedang login
            'nama_usaha' => $request->nama_usaha,
            'strategi_pemasaran' => $request->strategi_pemasaran,
            'file' => $filePath, // Path file atau null jika tidak ada 
            'status' => 'menunggu',
        ]);

        // KelayakanPemasaran::create($request->all());
        
        return redirect()->route('kelayakanUsaha')->with('success', 'Pengajuan Kelayakan Pemasaran berhasil diajukan.');
        // return redirect()->back()->with('success', 'Pengajuan Kelayakan Pemasaran berhasil diajukan.');
    }

    public function updateUserPemasaran (Request $request, $id_pemasaran)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'strategi_pemasaran' => 'required|string',
        ]);

        $kelayakanPemasaran = KelayakanPemasaran::findOrFail($id_pemasaran);

        $kelayakanPemasaran->nama_usaha = $request->nama_usaha;
        $kelayakanPemasaran->strategi_pemasaran = $request->strategi_pemasaran;
        $kelayakanPemasaran->status = "menunggu";
        $kelayakanPemasaran->save();

        return redirect()->route('kelayakanUsaha', ['id_pemasaran' => $id_pemasaran])->with('success', 'Pengajuan berhasil.');
    }

    public function updatePemasaran(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,png|max:2048', // Validasi file wajib ada
        ]);

        // Temukan data pengajuan berdasarkan ID
        $kelayakanPemasaran = KelayakanPemasaran::findOrFail($id);

        // Simpan file baru
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('kelayakan_operasional', 'public');
            $kelayakanPemasaran->file = $filePath; // Update path file
        }

        // Update status menjadi 'diterima'
         $kelayakanPemasaran->status = 'diterima';
         $kelayakanPemasaran->save(); // Simpan perubahan
 
         return redirect()->route('pemasaran')->with('success', 'Pengajuan diterima dan sertifikat berhasil diupload.');
    }

    public function rejectPemasaran (Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'message' => 'required|string|max:1000', // Pesan harus diisi
        ]);

         // Temukan data pengajuan berdasarkan ID
         $kelayakanPemasaran = KelayakanPemasaran::findOrFail($id);

          // Simpan pesan ke public storage
        $fileName = 'rejection_message_' . $id . '.txt';
        $filePath = 'kelayakan_pemasaran_rejections/' . $fileName;
       \Storage::disk('public')->put($filePath, $request->message);

          // Update status menjadi 'ditolak'
          $kelayakanPemasaran->status = 'ditolak';
          $kelayakanPemasaran->file = $filePath; // Simpan path pesan ke kolom file
          $kelayakanPemasaran->save();
  
          return redirect()->route('pemasaran')->with('success', 'Pengajuan berhasil ditolak.');
    }

    public function finansial(Request $request)
    {
        $search = $request->input('search');

        $dataFinansial = KelayakanFinansial::where('nama_usaha', 'like', "%{$search}%")
                        ->paginate(10);

        return view('admin.finansial', compact('dataFinansial'));
    }

    public function operasional(Request $request)
    {
        $search = $request->input('search');

        $dataOperasional = KelayakanOperasional::where('nama_usaha', 'like', "%{$search}%")
                        ->paginate(10);

        return view('admin.operasional', compact('dataOperasional'));
    }

    public function pemasaran(Request $request)
    {
        $search = $request->input('search');

        $dataPemasaran = KelayakanPemasaran::where('nama_usaha', 'like', "%{$search}%")
                        ->paginate(10);

        return view('admin.pemasaran', compact('dataPemasaran'));
    }
}
