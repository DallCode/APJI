<?php

namespace App\Http\Controllers;

use App\Models\PengajuanAsistenKoki;
use Illuminate\Http\Request;
use App\Models\PengajuanHalal;
use App\Models\DataPengguna;
use App\Models\User;
use App\Models\PengajuanKoki;
use Illuminate\Support\Facades\Redis;

class PengajuanSertifikatController extends Controller
{
    public function create()
    {
        return view('anggota.pengajuanSertifikat');
    }

    public function halal(Request $request)
    {
        $search = $request->input('search');

        // Jika ada pencarian, filter berdasarkan nama usaha
        $halalData = PengajuanHalal::where('nama_usaha', 'like', "%{$search}%")
                    ->paginate(10);

        return view('admin.halal', compact('halalData'));
    }

    public function koki(Request $request)
    {
        $search = $request->input('search');

        $kokiData = PengajuanKoki::where('nama_lengkap', 'like', "%{$search}%")
                    ->paginate(10);

        return view('admin.koki', compact('kokiData'));
    }

    public function asisten(Request $request)
    {
        $search = $request->input('search');

        $asistenData = PengajuanAsistenKoki::where('nama_lengkap', 'like', "%{$search}%")
                    ->paginate(10);

        return view('admin.asisten-koki', compact('asistenData'));
    }

    public function storeHalal(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'alamat_usaha' => 'required|string',
            'jenis_usaha' => 'required|string',
            'nama_produk' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // Validasi file
        ]);

        // Simpan file jika ada
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('pengajuan_halal', 'public'); // Simpan di storage/public/pengajuan_halal
        }

        // Simpan data ke database
        PengajuanHalal::create([
            'id_pengguna' => auth()->user()->dataPengguna->id_pengguna, // Gunakan ID user yang sedang login
            'nama_usaha' => $request->nama_usaha,
            'alamat_usaha' => $request->alamat_usaha,
            'jenis_usaha' => $request->jenis_usaha,
            'nama_produk' => $request->nama_produk,
            'file' => $filePath, // Path file atau null jika tidak ada file
            'status' => 'menunggu', // Status default
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('anggota.pengajuanSertifikat')->with('success', 'Pengajuan berhasil diajukan.');
    }

    public function updateUserHalal(Request $request, $id_detail)
    {
        // return $request;
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'alamat_usaha' => 'required|string',
            'jenis_usaha' => 'required|string',
            'nama_produk' => 'required|string|max:255',
        ]);

        $pengajuanHalal = PengajuanHalal::findOrFail($id_detail);

        $pengajuanHalal->update([
            'nama_usaha' => $request->nama_usaha,
            'alamat_usaha' => $request->alamat_usaha,
            'jenis_usaha' => $request->jenis_usaha,
            'nama_produk' => $request->nama_produk,
            'status' => 'menunggu',
        ]);

        return redirect()->route('anggota.pengajuanSertifikat')->with('success', 'Pengajuan berhasil diperbarui.');
    }


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

    public function createKoki()
    {
        return view('anggota.pengajuan-sertifikat');
    }

    public function storeKoki(Request $request)
    {
        // return $request;
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'pengalaman_kerja' => 'required|string',
            'pendidikan_terakhir' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // Validasi file
        ]);
        // dd(auth()->user());

        // Simpan file jika ada
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('pengajuan_koki', 'public'); // Simpan di storage/public/pengajuan_halal
        }

        PengajuanKoki::create([
            'id_pengguna' => auth()->user()->dataPengguna->id_pengguna, // Gunakan ID user yang sedang login
            'nama_lengkap' => $request->nama_lengkap,
            'pengalaman_kerja' => $request->pengalaman_kerja,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'file' => $filePath, // Path file atau null jika tidak ada file
            'status' => 'menunggu', //default
        ]);

        return redirect()->route('anggota.pengajuanSertifikat')->with('success', 'Pengajuan berhasil diajukan.');
    }

    public function updateUserKoki(Request $request, $id_detail)
    {
        // return $request;
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'pengalaman_kerja' => 'required|string',
            'pendidikan_terakhir' => 'required|string',
        ]);

        $pengajuanKoki = PengajuanKoki::findOrFail($id_detail);

        $pengajuanKoki->update([
            'nama_lengkap' => $request->nama_lengkap,
            'pengalaman_kerja' => $request->pengalaman_kerja,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'status' => 'menunggu',
        ]);

        return redirect()->route('anggota.pengajuanSertifikat')->with('success', 'Pengajuan berhasil diperbarui.');
    }

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

    public function createAsisten()
    {
        return view('anggota.pengajuan-sertifikat');
    }

    public function storeAsisten(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'keahlian_khusus' => 'required|string',
            'surat_pengantar' => 'nullable|file|mimes:pdf|max:10240', // Hanya file PDF yang diizinkan
            'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // Validasi file
        ]);

        $fileSuratPengantar = null;
        $fileDokumen = null;

        if ($request->hasFile('surat_pengantar')) {
            $fileSuratPengantar = $request->file('surat_pengantar')->store('surat_pengantar', 'public');
        }

        if ($request->hasFile('file')) {
            $fileDokumen = $request->file('file')->store('pengajuan_asisten_koki', 'public');
        }

        // Simpan ke database dengan field yang sesuai
        PengajuanAsistenKoki::create([
            'id_pengguna' => auth()->user()->dataPengguna->id_pengguna,
            'nama_lengkap' => $request->nama_lengkap,
            'keahlian_khusus' => $request->keahlian_khusus,
            'surat_pengantar' => $fileSuratPengantar,
            'file' => $fileDokumen,
            'status' => 'menunggu',
        ]);


        return redirect()->route('anggota.pengajuanSertifikat')->with('success', 'Pengajuan berhasil diajukan.');
    }

    public function updateUserAsisten(Request $request, $id_detail)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'keahlian_khusus' => 'required|string',
            'surat_pengantar' => 'nullable|file|mimes:pdf|max:10240', // Hanya file PDF yang diizinkan
        ]);

        $pengajuanAsistenKoki = PengajuanAsistenKoki::findOrFail($id_detail);

        $pengajuanAsistenKoki->update([
            'nama_lengkap' => $request->nama_lengkap,
            'keahlian_khusus' => $request->keahlian_khusus,
            'surat_pengantar' => $request->surat_pengantar,
            'status' => 'menunggu',
        ]);

        return redirect()->route('anggota.pengajuanSertifikat')->with('success', 'Pengajuan berhasil diperbarui.');
    }

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

        return redirect()->route('koki')->with('success', 'Pengajuan diterima dan sertifikat berhasil diupload.');
    }

    public function getFileUrl($id)
    {
        $pengajuanAsistenKoki = PengajuanAsistenKoki::find($id);
        if ($pengajuanAsistenKoki && $pengajuanAsistenKoki->file) {
            return response()->json(['url' => asset('storage/' . $pengajuanAsistenKoki->file)]);
        }
        return response()->json(['error' => 'File not found'], 404);
    }



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
