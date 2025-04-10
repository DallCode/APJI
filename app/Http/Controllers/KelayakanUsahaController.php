<?php

namespace App\Http\Controllers;

use App\Models\KelayakanFinansial;
use App\Models\KelayakanOperasional;
use App\Models\KelayakanPemasaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class KelayakanUsahaController extends Controller
{
    //mengajukan finansial
    public function storeFinansial(Request $request)
    {
        try {
            // Validasi input dengan pesan kustom
            $validatedData = $request->validate([
                'nama_usaha' => 'required|string|min:3|max:255',
                'laporan_keuangan' => 'required|file|mimes:pdf,docx|max:10240', // Hanya PDF atau DOCX, maksimal 10MB
                'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // Maksimal 2MB
            ], [
                'nama_usaha.required' => 'Nama usaha wajib diisi.',
                'nama_usaha.min' => 'Nama usaha minimal 3 karakter.',
                'nama_usaha.max' => 'Nama usaha tidak boleh lebih dari 255 karakter.',
                'laporan_keuangan.required' => 'Laporan keuangan wajib diunggah.',
                'laporan_keuangan.mimes' => 'Laporan keuangan harus dalam format PDF atau DOCX.',
                'laporan_keuangan.max' => 'Ukuran laporan keuangan maksimal 10MB.',
                'file.mimes' => 'File harus dalam format PDF, JPG, atau PNG.',
                'file.max' => 'Ukuran file maksimal 2MB.',
            ]);

            // Simpan file jika ada
            $filePath = null;
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('kelayakan_finansial', 'public');
            }

            // Simpan laporan keuangan
            $laporanKeuanganPath = $request->file('laporan_keuangan')->store('laporan_keuangan', 'public');

            // Simpan ke database
            KelayakanFinansial::create([
                'id_pengguna' => auth()->user()->dataPengguna->id_pengguna,
                'nama_usaha' => $validatedData['nama_usaha'],
                'laporan_keuangan' => $laporanKeuanganPath,
                'file' => $filePath,
                'status' => 'menunggu',
            ]);

            return redirect()->route('kelayakanUsaha')->with('success', 'Pengajuan Kelayakan Finansial berhasil diajukan.');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal mengajukan kelayakan finansial: ' . $e->getMessage());

            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }

    //untuk mengajukan ulang jika ditolak
    public function updateUserFinansial(Request $request, $id_finansial)
    {
        try {
            // Validasi input dengan pesan kustom
            $validatedData = $request->validate([
                'nama_usaha' => 'required|string|min:3|max:255',
                'laporan_keuangan' => 'nullable|file|mimes:pdf,docx|max:10240', // File opsional, hanya PDF/DOCX, maksimal 10MB
            ], [
                'nama_usaha.required' => 'Nama usaha wajib diisi.',
                'nama_usaha.min' => 'Nama usaha minimal 3 karakter.',
                'nama_usaha.max' => 'Nama usaha tidak boleh lebih dari 255 karakter.',
                'laporan_keuangan.mimes' => 'Laporan keuangan harus dalam format PDF atau DOCX.',
                'laporan_keuangan.max' => 'Ukuran laporan keuangan maksimal 10MB.',
            ]);

            // Cari data berdasarkan ID, jika tidak ditemukan akan melempar error 404
            $kelayakanFinansial = KelayakanFinansial::findOrFail($id_finansial);

            // Jika ada file baru, simpan dan update path-nya
            if ($request->hasFile('laporan_keuangan')) {
                $filePath = $request->file('laporan_keuangan')->store('laporan_keuangan', 'public');
                $kelayakanFinansial->laporan_keuangan = $filePath;
            }

            // Update data
            $kelayakanFinansial->nama_usaha = $validatedData['nama_usaha'];
            $kelayakanFinansial->status = "menunggu";
            $kelayakanFinansial->save();

            return redirect()->route('kelayakanUsaha', ['id_finansial' => $id_finansial])->with('success', 'Pengajuan berhasil diperbarui.');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal memperbarui kelayakan finansial: ' . $e->getMessage());

            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }

    //untuk aksi diadmin jika diterima
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

    //untuk diadmin jika ditolak
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
    
    //untuk mengajukan operasional
    public function storeOperasional(Request $request)
    {
        try {
            // Validasi input dengan pesan kustom
            $validatedData = $request->validate([
                'nama_usaha' => 'required|string|min:3|max:255',
                'deskripsi_operasional' => 'required|string|min:10|max:1000',
                'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // File opsional, hanya PDF/JPG/PNG, maksimal 2MB
            ], [
                'nama_usaha.required' => 'Nama usaha wajib diisi.',
                'nama_usaha.min' => 'Nama usaha minimal 3 karakter.',
                'nama_usaha.max' => 'Nama usaha tidak boleh lebih dari 255 karakter.',
                'deskripsi_operasional.required' => 'Deskripsi operasional wajib diisi.',
                'deskripsi_operasional.min' => 'Deskripsi operasional minimal 10 karakter.',
                'deskripsi_operasional.max' => 'Deskripsi operasional tidak boleh lebih dari 1000 karakter.',
                'file.mimes' => 'File harus dalam format PDF, JPG, atau PNG.',
                'file.max' => 'Ukuran file maksimal 2MB.',
            ]);

            // Simpan file jika ada
            $filePath = null;
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('kelayakan_operasional', 'public');
            }

            // Simpan ke database
            KelayakanOperasional::create([
                'id_pengguna' => auth()->user()->dataPengguna->id_pengguna, // Gunakan ID user yang sedang login
                'nama_usaha' => $validatedData['nama_usaha'],
                'deskripsi_operasional' => $validatedData['deskripsi_operasional'],
                'file' => $filePath, // Path file atau null jika tidak ada 
                'status' => 'menunggu',
            ]);

            return redirect()->route('kelayakanUsaha')->with('success', 'Pengajuan Kelayakan Operasional berhasil diajukan.');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal mengajukan Kelayakan Operasional: ' . $e->getMessage());

            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }

    //untuk mengajukan ulang jika ditolak 
    public function updateUserOperasional(Request $request, $id_operasional)
    {
        try {
            // Validasi input dengan pesan error kustom
            $validatedData = $request->validate([
                'nama_usaha' => 'required|string|min:3|max:255',
                'deskripsi_operasional' => 'required|string|min:10|max:1000',
            ], [
                'nama_usaha.required' => 'Nama usaha wajib diisi.',
                'nama_usaha.min' => 'Nama usaha minimal 3 karakter.',
                'nama_usaha.max' => 'Nama usaha tidak boleh lebih dari 255 karakter.',
                'deskripsi_operasional.required' => 'Deskripsi operasional wajib diisi.',
                'deskripsi_operasional.min' => 'Deskripsi operasional minimal 10 karakter.',
                'deskripsi_operasional.max' => 'Deskripsi operasional tidak boleh lebih dari 1000 karakter.',
            ]);

            // Cek apakah data ada di database
            $kelayakanOperasional = KelayakanOperasional::findOrFail($id_operasional);

            // Update data
            $kelayakanOperasional->update([
                'nama_usaha' => $validatedData['nama_usaha'],
                'deskripsi_operasional' => $validatedData['deskripsi_operasional'],
                'status' => 'menunggu',
            ]);

            return redirect()->route('kelayakanUsaha', ['id_operasional' => $id_operasional])->with('success', 'Pengajuan berhasil diperbarui.');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal memperbarui Kelayakan Operasional: ' . $e->getMessage());

            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }

    //untuk diadmin jika diterima
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

    //untuk diadmin jika ditolak
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
    
    //mengajukan pemasaran
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

    //untuk mengajukan ulang jika ditolak
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

    //untuk diadmin jika diterima
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

    //untuk diadmin jika ditolak
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

    //untuk halaman finansial diadmin
    public function finansial(Request $request)
    {
        $search = $request->input('search');

        $dataFinansial = KelayakanFinansial::where('nama_usaha', 'like', "%{$search}%")
                        ->paginate(10);

        return view('admin.finansial', compact('dataFinansial'));
    }

    //untuk halaman operasional di admin
    public function operasional(Request $request)
    {
        $search = $request->input('search');

        $dataOperasional = KelayakanOperasional::where('nama_usaha', 'like', "%{$search}%")
                        ->paginate(10);

        return view('admin.operasional', compact('dataOperasional'));
    }

    //untuk halaman pemasaran di admin
    public function pemasaran(Request $request)
    {
        $search = $request->input('search');

        $dataPemasaran = KelayakanPemasaran::where('nama_usaha', 'like', "%{$search}%")
                        ->paginate(10);

        return view('admin.pemasaran', compact('dataPemasaran'));
    }
}
