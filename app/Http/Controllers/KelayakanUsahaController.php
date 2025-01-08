<?php

namespace App\Http\Controllers;

use App\Models\KelayakanFinansial;
use App\Models\KelayakanOperasional;
use App\Models\KelayakanPemasaran;
use Illuminate\Http\Request;

class KelayakanUsahaController extends Controller
{
    public function storeFinansial(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'laporan_keuangan' => 'required|file|mimes:pdf,docx',
        ]);
        // $request->all();

        $path = $request->file('laporan_keuangan')->store('laporan_keuangan');
        

        KelayakanFinansial::create([
            'nama_usaha' => $request->nama_usaha,
            'laporan_keuangan' => $path,
        ]);

        return redirect()->route('anggota.kelayakan-usaha')->with('success', 'Pengajuan Kelayakan Finansial berhasil diajukan.');
        // return redirect()->back()->with('success', 'Pengajuan Kelayakan Finansial berhasil diajukan.');
    }
    
    public function storeOperasional(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'deskripsi_operasional' => 'required|string',
        ]);
        
        KelayakanOperasional::create($request->all());
           
        return redirect()->route('anggota.kelayakan-usaha')->with('success', 'Pengajuan Kelayakan Operasional berhasil diajukan.');
        // return redirect()->back()->with('success', 'Pengajuan Kelayakan Operasional berhasil diajukan.');
    }
    
    public function storePemasaran(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'strategi_pemasaran' => 'required|string',
        ]);
        
        KelayakanPemasaran::create($request->all());
        
        return redirect()->route('anggota.kelayakan-usaha')->with('success', 'Pengajuan Kelayakan Pemasaran berhasil diajukan.');
        // return redirect()->back()->with('success', 'Pengajuan Kelayakan Pemasaran berhasil diajukan.');
    }

    public function finansial()
    {
        $dataFinansial = KelayakanFinansial::all();

        return view('admin.finansial', compact('dataFinansial'));
    }

    public function operasional()
    {
        $dataOperasional = KelayakanOperasional::all();

        return view('admin.operasional', compact('dataOperasional'));
    }

    public function pemasaran()
    {
        $dataPemasaran = KelayakanPemasaran::all();

        return view('admin.pemasaran', compact('dataPemasaran'));
    }
}
