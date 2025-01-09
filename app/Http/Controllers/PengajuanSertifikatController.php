<?php

namespace App\Http\Controllers;

use App\Models\PengajuanAsistenKoki;
use Illuminate\Http\Request;
use App\Models\PengajuanHalal;
use App\Models\DataPengguna;
use App\Models\User;
use App\Models\PengajuanKoki;

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
        $halalData = PengajuanHalal::where('nama_usaha', 'like', "%{$search}%")->get();

        return view('admin.halal', compact('halalData'));
    }

    public function koki()
    {
        $kokiData = PengajuanKoki::all();

        return view('admin.koki', compact('kokiData'));
    }

    public function asisten()
    {
        $asistenData = PengajuanAsistenKoki::all();

        return view('admin.asisten-koki', compact('asistenData'));
    }
    
    public function storeHalal(Request $request)
    {
        // return $request;
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'alamat_usaha' => 'required|string',
            'jenis_usaha' => 'required|string',
            'nama_produk' => 'required|string|max:255',
        ]);
        // dd(auth()->user());

        PengajuanHalal::create([
            'id_pengguna' => auth()->user()->dataPengguna->id_pengguna, // Gunakan ID user yang sedang login
            'nama_usaha' => $request->nama_usaha,
            'alamat_usaha' => $request->alamat_usaha,
            'jenis_usaha' => $request->jenis_usaha,
            'nama_produk' => $request->nama_produk,
            'status' => 'menunggu',
        ]);

        return redirect()->route('anggota.pengajuan-sertifikat')->with('success', 'Pengajuan berhasil diajukan.');
    }

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
        ]);
        // dd(auth()->user());

        PengajuanKoki::create([
            'id_pengguna' => auth()->user()->dataPengguna->id_pengguna, // Gunakan ID user yang sedang login
            'nama_lengkap' => $request->nama_lengkap,
            'pengalaman_kerja' => $request->pengalaman_kerja,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'status' => 'menunggu', //default
        ]);

        return redirect()->route('anggota.pengajuanSertifikat')->with('success', 'Pengajuan berhasil diajukan.');
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
        ]);

        // Simpan file PDF jika ada
        if ($request->hasFile('surat_pengantar')) {
            $filePath = $request->file('surat_pengantar')->store('surat_pengantar', 'public');
        } else {
            $filePath = null; // Jika tidak ada file
        }

        // Simpan pengajuan ke database
        PengajuanAsistenKoki::create([
            'id_pengguna' => auth()->user()->dataPengguna->id_pengguna, // Gunakan ID user yang sedang login
            'nama_lengkap' => $request->nama_lengkap,
            'keahlian_khusus' => $request->keahlian_khusus,
            'surat_pengantar' => $filePath,
        ]);

        return redirect()->route('anggota.pengajuanSertifikat')->with('success', 'Pengajuan berhasil diajukan.');
    }
}
