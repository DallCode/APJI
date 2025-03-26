<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\PengajuanHalal;
use App\Models\PengajuanKoki;
use App\Models\PengajuanAsistenKoki;
use App\Models\KelayakanFinansial;
use App\Models\KelayakanOperasional;
use App\Models\KelayakanPemasaran;

class LaporanExport implements FromView
{
    protected $tahun, $bulan;

    public function __construct($tahun, $bulan)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    public function view(): View
    {
        $data = [
            'totalSertifikat' => PengajuanHalal::count() + PengajuanKoki::count() + PengajuanAsistenKoki::count(),
            'totalKelayakan' => KelayakanFinansial::count() + KelayakanOperasional::count() + KelayakanPemasaran::count(),
        ];

        return view('admin.laporan_export', $data);
    }
}
