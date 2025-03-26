<?php

namespace App\Http\Controllers;

use App\Models\DataPengguna;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function registerShow()
    {
        return view('login.registerForm');
    }

    public function register(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'nama_usaha' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'kode_pos' => 'required',
            'no_telp' => 'required|unique:data_pengguna,no_telp',
            'nama_pemilik' => 'required',
            'no_ktp' => 'required|unique:data_pengguna,no_ktp',
            'no_sku' => 'nullable|unique:data_pengguna,no_sku',
            'no_npwp' => 'nullable|unique:data_pengguna,no_npwp',
            'k_usaha' => 'required|in:Mikro,Kecil,Menengah',
            'j_usaha' => 'required|in:Makanan,Minuman,Jasa',
        ]);
    
        try {
            // Simpan user terlebih dahulu
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'anggota',
                'status' => 'active',
            ]);
    
            // Simpan data pengguna dengan menghubungkan ke user yang baru dibuat
            DataPengguna::create([
                'id' => $user->id, // Pastikan 'id' di data_pengguna terkait dengan user
                'email' => $request->email,
                'nama_usaha' => $request->nama_usaha,
                'alamat' => $request->alamat,
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'kecamatan' => $request->kecamatan,
                'kode_pos' => $request->kode_pos,
                'no_telp' => $request->no_telp,
                'nama_pemilik' => $request->nama_pemilik,
                'no_ktp' => $request->no_ktp,
                'no_sku' => $request->no_sku,
                'no_npwp' => $request->no_npwp,
                'k_usaha' => $request->k_usaha,
                'j_usaha' => $request->j_usaha,
            ]);
    
            // Redirect ke halaman login dengan pesan sukses
            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silahkan Login.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangani duplikat data berdasarkan kode error SQL
            if ($e->getCode() == 23000) { // 23000 adalah kode SQL untuk pelanggaran constraint
                return back()->with('error', 'Data sudah terdaftar. Harap gunakan data yang berbeda.');
            }
    
            // Tangani kesalahan lainnya
            return back()->with('error', 'Terjadi kesalahan saat pendaftaran: ' . $e->getMessage());
        }
    }
    


    // public function store(Request $request)
    // {
    //     // Validasi file upload
    //     $request->validate([
    //         'ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    //         'npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    //         'sku' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    //     ]);

    //     $data = [];

    //     // Menyimpan file KTP jika ada
    //     if ($request->hasFile('ktp')) {
    //         $data['ktp'] = $request->file('ktp')->store('uploads/ktp');
    //     }

    //     // Menyimpan file NPWP jika ada
    //     if ($request->hasFile('npwp')) {
    //         $data['npwp'] = $request->file('npwp')->store('uploads/npwp');
    //     }

    //     // Menyimpan file SKU/PIRT jika ada
    //     if ($request->hasFile('sku')) {
    //         $data['sku'] = $request->file('sku')->store('uploads/sku');
    //     }

    //     // Lakukan penyimpanan lainnya
    //     return back()->with('message', 'File berhasil diupload!');
    // }

}