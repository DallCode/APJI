<?php

namespace App\Http\Controllers;

use App\Models\PengajuanAsistenKoki;
use Illuminate\Http\Request;
use App\Models\PengajuanHalal;
use App\Models\DataPengguna;
use App\Models\User;
use App\Models\PengajuanKoki;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PengajuanSertifikatController extends Controller
{
    //untuk membuka halaman pengajuan sertifikat dianggota
    public function create()
    {
        return view('anggota.pengajuanSertifikat');
    }

    //untuk membuka halaman halal di admin
    public function halal(Request $request)
    {
        $search = $request->input('search');

        // Jika ada pencarian, filter berdasarkan nama usaha
        $halalData = PengajuanHalal::where('nama_usaha', 'like', "%{$search}%")
                    ->paginate(2);

        return view('admin.halal', compact('halalData'));
    }

    //untuk membuka halama koki di adminn
    public function koki(Request $request)
    {
        $search = $request->input('search');

        $kokiData = PengajuanKoki::where('nama_lengkap', 'like', "%{$search}%")
                    ->paginate(10);

        return view('admin.koki', compact('kokiData'));
    }

    //untuk membuka halaman asisten koki di admin
    public function asisten(Request $request)
    {
        $search = $request->input('search');

        $asistenData = PengajuanAsistenKoki::where('nama_lengkap', 'like', "%{$search}%")
                    ->paginate(10);

        return view('admin.asisten-koki', compact('asistenData'));
    }

    //untuk mengajukan halal
    public function storeHalal(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'nama_usaha' => 'required|string|max:255',
                'alamat_usaha' => 'required|string|min:10|max:500',
                'jenis_usaha' => 'required|string|min:3|max:255',
                'nama_produk' => 'required|string|max:255',
                'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // Maksimal 2MB
            ], [
                'nama_usaha.required' => 'Nama usaha wajib diisi.',
                'nama_usaha.max' => 'Nama usaha tidak boleh lebih dari 255 karakter.',
                'alamat_usaha.required' => 'Alamat usaha wajib diisi.',
                'alamat_usaha.min' => 'Alamat usaha minimal 10 karakter.',
                'alamat_usaha.max' => 'Alamat usaha tidak boleh lebih dari 500 karakter.',
                'jenis_usaha.required' => 'Jenis usaha wajib diisi.',
                'jenis_usaha.min' => 'Jenis usaha minimal 3 karakter.',
                'jenis_usaha.max' => 'Jenis usaha tidak boleh lebih dari 255 karakter.',
                'nama_produk.required' => 'Nama produk wajib diisi.',
                'nama_produk.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
                'file.mimes' => 'Format file harus PDF, JPG, atau PNG.',
                'file.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
            ]);

            // Simpan file jika ada
            $filePath = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('pengajuan_halal', $fileName, 'public');
                
                if (!$filePath) {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengunggah file, silakan coba lagi.');
                }
            }

            // Simpan data ke database
            PengajuanHalal::create([
                'id_pengguna' => auth()->user()->dataPengguna->id_pengguna ?? null, // Pastikan user memiliki dataPengguna
                'nama_usaha' => $validatedData['nama_usaha'],
                'alamat_usaha' => $validatedData['alamat_usaha'],
                'jenis_usaha' => $validatedData['jenis_usaha'],
                'nama_produk' => $validatedData['nama_produk'],
                'file' => $filePath,
                'status' => 'menunggu',
            ]);

            return redirect()->route('anggota.pengajuanSertifikat')->with('success', 'Pengajuan berhasil diajukan.');

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan pengajuan sertifikasi halal: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan pengajuan. Silakan coba lagi.');
        }
    }


    //untuk mengajukan ulang halal jika ditolak
    public function updateUserHalal(Request $request, $id_detail)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'alamat_usaha' => 'required|string|min:10|max:500',
            'jenis_usaha' => 'required|string|min:3|max:255',
            'nama_produk' => 'required|string|max:255',
        ], [
            'nama_usaha.required' => 'Nama usaha wajib diisi.',
            'nama_usaha.max' => 'Nama usaha tidak boleh lebih dari 255 karakter.',
            'alamat_usaha.required' => 'Alamat usaha wajib diisi.',
            'alamat_usaha.min' => 'Alamat usaha minimal 10 karakter.',
            'alamat_usaha.max' => 'Alamat usaha tidak boleh lebih dari 500 karakter.',
            'jenis_usaha.required' => 'Jenis usaha wajib diisi.',
            'jenis_usaha.min' => 'Jenis usaha minimal 3 karakter.',
            'jenis_usaha.max' => 'Jenis usaha tidak boleh lebih dari 255 karakter.',
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
        ]);

        try {
            // Cek apakah data ditemukan
            $pengajuanHalal = PengajuanHalal::findOrFail($id_detail);

            // Update data
            $pengajuanHalal->update([
                'nama_usaha' => $validatedData['nama_usaha'],
                'alamat_usaha' => $validatedData['alamat_usaha'],
                'jenis_usaha' => $validatedData['jenis_usaha'],
                'nama_produk' => $validatedData['nama_produk'],
                'status' => 'menunggu',
            ]);

            return redirect()->route('anggota.pengajuanSertifikat')->with('success', 'Pengajuan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui pengajuan: ' . $e->getMessage());
        }
    }


    //untuk terima pengajuan halal di admin
    public function updateHalal(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,png|max:2048', // Validasi file
        ]);

        // Temukan data pengajuan berdasarkan ID
        $pengajuanHalal = PengajuanHalal::findOrFail($id);

        // Simpan file jika ada
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('sertifikat_halal', 'public');
            $pengajuanHalal->file = $filePath; // Simpan path file
        }

        // Update status sesuai request
        if ($request->has('status')) {
            $pengajuanHalal->status = $request->status;
        } else {
            $pengajuanHalal->status = 'diterima'; // Default jika tidak ada status dikirim
        }

        // Simpan perubahan
        $pengajuanHalal->save();

        // Cek apakah request berasal dari AJAX atau form biasa
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Pengajuan diterima dan sertifikat berhasil diupload.');
    }

    //untuk tolak pengajuan halal diadmin
    public function rejectHalal(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'message' => 'required|string|max:1000', // Pesan harus diisi
        ]);

        // Temukan data pengajuan berdasarkan ID
        $pengajuanHalal = PengajuanHalal::findOrFail($id);

        // Simpan pesan ke public storage
        $fileName = 'rejection_message_' . $id . '.txt';
        $filePath = 'halal_rejections/' . $fileName;
        \Storage::disk('public')->put($filePath, $request->message);

        // Update status menjadi 'ditolak'
        $pengajuanHalal->status = 'ditolak';
        $pengajuanHalal->file = $filePath; // Simpan path pesan ke kolom file
        $pengajuanHalal->save();

        return redirect()->route('halal')->with('success', 'Pengajuan berhasil ditolak.');
    }


    // public function updateHalal(Request $request, $id)
    // {
    //     // return $request;
    //     $request->validate([
    //         'status' => 'required|string|in:menunggu,ditolak,diterima',
    //         'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
    //     ]);

    //      // Cari pengajuan halal berdasarkan ID
    //     $pengajuanHalal = PengajuanHalal::findOrFail($id);

    //     // Update status pengajuan halal
    //     $pengajuanHalal->status = $request->status;

    //      // Jika ada file yang diupload, simpan file tersebut sebagai binary
    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $fileContent = file_get_contents($file->getRealPath()); // Membaca file sebagai binary
    //         $pengajuanHalal->file_sertifikat = $fileContent; // Simpan file binary ke database
    //     }

    //     // Simpan perubahan status dan file ke database
    //     $pengajuanHalal->save();

    //     return redirect()->route('admin.halal')->with('success', 'Status pengajuan berhasil diperbarui dan sertifikat disimpan.');
    // }

    //untuk membuka halaman pengajuan sertifikat di anggota
    public function createKoki()
    {
        return view('anggota.pengajuan-sertifikat');
    }

    //untuk mengajukan koki
    public function storeKoki(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'nama_lengkap' => 'required|string|min:3|max:255',
                'pengalaman_kerja' => 'required|string|min:10|max:500',
                'pendidikan_terakhir' => 'required|string|min:3|max:255',
                'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // Maksimal 2MB
            ], [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
                'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter.',
                'nama_lengkap.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
                'pengalaman_kerja.required' => 'Pengalaman kerja wajib diisi.',
                'pengalaman_kerja.min' => 'Pengalaman kerja minimal 10 karakter.',
                'pengalaman_kerja.max' => 'Pengalaman kerja tidak boleh lebih dari 500 karakter.',
                'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib diisi.',
                'pendidikan_terakhir.min' => 'Pendidikan terakhir minimal 3 karakter.',
                'pendidikan_terakhir.max' => 'Pendidikan terakhir tidak boleh lebih dari 255 karakter.',
                'file.mimes' => 'Format file harus PDF, JPG, atau PNG.',
                'file.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
            ]);

            // Simpan file jika ada
            $filePath = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('pengajuan_koki', $fileName, 'public');

                if (!$filePath) {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengunggah file, silakan coba lagi.');
                }
            }

            // Simpan data ke database
            PengajuanKoki::create([
                'id_pengguna' => auth()->user()->dataPengguna->id_pengguna ?? null, // Pastikan user memiliki dataPengguna
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'pengalaman_kerja' => $validatedData['pengalaman_kerja'],
                'pendidikan_terakhir' => $validatedData['pendidikan_terakhir'],
                'file' => $filePath,
                'status' => 'menunggu',
            ]);

            return redirect()->route('anggota.pengajuanSertifikat')->with('success', 'Pengajuan berhasil diajukan.');

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan pengajuan koki: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan pengajuan. Silakan coba lagi.');
        }
    }

    //untuk mengajukan ulang koki jika ditolak
    public function updateUserKoki(Request $request, $id_detail)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'nama_lengkap' => 'required|string|min:3|max:255',
                'pengalaman_kerja' => 'required|string|min:10|max:500',
                'pendidikan_terakhir' => 'required|string|min:3|max:255',
            ], [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
                'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter.',
                'nama_lengkap.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
                'pengalaman_kerja.required' => 'Pengalaman kerja wajib diisi.',
                'pengalaman_kerja.min' => 'Pengalaman kerja minimal 10 karakter.',
                'pengalaman_kerja.max' => 'Pengalaman kerja tidak boleh lebih dari 500 karakter.',
                'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib diisi.',
                'pendidikan_terakhir.min' => 'Pendidikan terakhir minimal 3 karakter.',
                'pendidikan_terakhir.max' => 'Pendidikan terakhir tidak boleh lebih dari 255 karakter.',
            ]);

            // Cari data pengajuan
            $pengajuanKoki = PengajuanKoki::findOrFail($id_detail);

            // Update data
            $pengajuanKoki->update([
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'pengalaman_kerja' => $validatedData['pengalaman_kerja'],
                'pendidikan_terakhir' => $validatedData['pendidikan_terakhir'],
                'status' => 'menunggu',
            ]);

            return redirect()->route('anggota.pengajuanSertifikat')->with('success', 'Pengajuan berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Gagal memperbarui pengajuan koki: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui pengajuan. Silakan coba lagi.');
        }
    }

    //untuk terima koki di admin
    public function updateKoki(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,png|max:2048', // Validasi file wajib ada
        ]);

        // Temukan data pengajuan berdasarkan ID
        $pengajuanKoki = PengajuanKoki::findOrFail($id);

        // Simpan file jika ada
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('sertifikat_koki', 'public');
            $pengajuanKoki->file = $filePath; // Simpan path file
        }

        // Update status jika dikirim dari request
        if ($request->has('status')) {
            $pengajuanKoki->status = $request->status;
        } else {
            $pengajuanKoki->status = 'diterima'; // Default jika tidak ada status dikirim
        }

        // Simpan perubahan
        $pengajuanKoki->save();

        // Cek apakah request berasal dari AJAX atau form biasa
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('koki')->with('success', 'Pengajuan diterima dan sertifikat berhasil diupload.');
    }

    //untuk tolak koki di admin
    public function rejectKoki(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'message' => 'required|string|max:1000', // Pesan harus diisi
        ]);

        // Temukan data pengajuan berdasarkan ID
        $pengajuanKoki = PengajuanKoki::findOrFail($id);

        // Simpan pesan ke public storage
        $fileName = 'rejection_message_' . $id . '.txt';
        $filePath = 'koki_rejections/' . $fileName;
        \Storage::disk('public')->put($filePath, $request->message);

        // Update status menjadi 'ditolak'
        $pengajuanKoki->status = 'ditolak';
        $pengajuanKoki->file = $filePath; // Simpan path pesan ke kolom file
        $pengajuanKoki->save();

        return redirect()->route('koki')->with('success', 'Pengajuan berhasil ditolak.');
    }

    //untuk membuka halaman asisten koki di anggota
    public function createAsisten()
    {
        return view('anggota.pengajuan-sertifikat');
    }

    //untuk mengajukan asisten koki 
    public function storeAsisten(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'keahlian_khusus' => 'required|string',
                'surat_pengantar' => 'nullable|file|mimes:pdf|max:10240', // Hanya file PDF, max 10MB
                'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // File tambahan, max 2MB
            ], [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
                'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter.',
                'nama_lengkap.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
                'keahlian_khusus.required' => 'Keahlian Khusus wajib diisi.',
                'keahlian_khusus.min' => 'Keahlian khusus minimal 5 karakter.',
                'keahlian_khusus.max' => 'Keahlian khusus tidak boleh lebih dari 255 karakter.',
                'surat_pengantar.mimes' => 'Format file harus PDF.',
                'surat_pengantar.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
                'file.mimes' => 'Format file harus PDF.',
                'file.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
            ]);

            // Simpan file jika ada
            $fileSuratPengantar = null;
            $fileDokumen = null;

            if ($request->hasFile('surat_pengantar')) {
                $fileSuratPengantar = $request->file('surat_pengantar')->store('surat_pengantar', 'public');
            }

            if ($request->hasFile('file')) {
                $fileDokumen = $request->file('file')->store('pengajuan_asisten_koki', 'public');
            }

            // Simpan data ke database
            PengajuanAsistenKoki::create([
                'id_pengguna' => auth()->user()->dataPengguna->id_pengguna,
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'keahlian_khusus' => $validatedData['keahlian_khusus'],
                'surat_pengantar' => $fileSuratPengantar,
                'file' => $fileDokumen,
                'status' => 'menunggu',
            ]);

            return redirect()->route('anggota.pengajuanSertifikat')->with('success', 'Pengajuan berhasil diajukan.');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal menyimpan pengajuan asisten koki: ' . $e->getMessage());

            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }

    //untuk mengajukan ulang kembali jika ditolak
    public function updateUserAsisten(Request $request, $id_detail)
    {
        try {
            // Validasi input dengan pesan kustom
            $validatedData = $request->validate([
                'nama_lengkap' => 'required|string|min:3|max:255',
                'keahlian_khusus' => 'required|string|min:5|max:255',
                'surat_pengantar' => 'nullable|file|mimes:pdf|max:10240', // Maksimal 10MB, hanya PDF
            ], [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
                'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter.',
                'nama_lengkap.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
                'keahlian_khusus.required' => 'Keahlian khusus wajib diisi.',
                'keahlian_khusus.min' => 'Keahlian khusus minimal 5 karakter.',
                'keahlian_khusus.max' => 'Keahlian khusus tidak boleh lebih dari 255 karakter.',
                'surat_pengantar.mimes' => 'Surat pengantar harus dalam format PDF.',
                'surat_pengantar.max' => 'Ukuran surat pengantar maksimal 10MB.',
            ]);

            // Cari data pengajuan berdasarkan ID
            $pengajuanAsistenKoki = PengajuanAsistenKoki::findOrFail($id_detail);

            // Simpan file surat pengantar jika ada
            if ($request->hasFile('surat_pengantar')) {
                $fileSuratPengantar = $request->file('surat_pengantar')->store('surat_pengantar', 'public');
            } else {
                $fileSuratPengantar = $pengajuanAsistenKoki->surat_pengantar; // Gunakan file lama jika tidak ada yang baru
            }

            // Update data pengajuan
            $pengajuanAsistenKoki->update([
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'keahlian_khusus' => $validatedData['keahlian_khusus'],
                'surat_pengantar' => $fileSuratPengantar,
                'status' => 'menunggu',
            ]);

            return redirect()->route('anggota.pengajuanSertifikat')->with('success', 'Pengajuan berhasil diperbarui.');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal memperbarui pengajuan asisten koki: ' . $e->getMessage());

            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }

    //untuk terima asiten di admin
    public function updateAsisten(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,png|max:2048', // Validasi file wajib ada
        ]);

        // Temukan data pengajuan berdasarkan ID
        $pengajuanAsistenKoki = PengajuanAsistenKoki::findOrFail($id);

        // Simpan file baru
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('sertifikat_asisten_koki', 'public');
            $pengajuanAsistenKoki->file = $filePath; // Update path file
        }

        // Update status menjadi 'diterima'
        $pengajuanAsistenKoki->status = 'diterima';
        $pengajuanAsistenKoki->save(); // Simpan perubahan

        return redirect()->route('asisten')->with('success', 'Pengajuan diterima dan sertifikat berhasil diupload.');
    }

    public function getFileUrl($id)
    {
        $pengajuanAsistenKoki = PengajuanAsistenKoki::find($id);
        if ($pengajuanAsistenKoki && $pengajuanAsistenKoki->file) {
            return response()->json(['url' => asset('storage/' . $pengajuanAsistenKoki->file)]);
        }
        return response()->json(['error' => 'File not found'], 404);
    }

    //untuk tolak asisten di admin
    public function rejectAsisten(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'message' => 'required|string|max:1000', // Pesan harus diisi
        ]);

        // Temukan data pengajuan berdasarkan ID
        $pengajuanAsistenKoki = PengajuanAsistenKoki::findOrFail($id);

        // Simpan pesan ke public storage
        $fileName = 'rejection_message_' . $id . '.txt';
        $filePath = 'asisten_koki_rejections/' . $fileName;
        \Storage::disk('public')->put($filePath, $request->message);

        // Update status menjadi 'ditolak'
        $pengajuanAsistenKoki->status = 'ditolak';
        $pengajuanAsistenKoki->file = $filePath; // Simpan path pesan ke kolom file
        $pengajuanAsistenKoki->save();

        return redirect()->route('halal')->with('success', 'Pengajuan berhasil ditolak.');
    }
}