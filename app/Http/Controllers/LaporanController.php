<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanHalal;
use App\Models\PengajuanKoki;
use App\Models\PengajuanAsistenKoki;
use App\Models\KelayakanFinansial;
use App\Models\KelayakanOperasional;
use App\Models\KelayakanPemasaran;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan');

        $querySertifikat = [
            'Sertifikat Halal' => PengajuanHalal::query(),
            'Sertifikat Koki' => PengajuanKoki::query(),
            'Sertifikat Asisten Koki' => PengajuanAsistenKoki::query(),
        ];

        foreach ($querySertifikat as $key => $query) {
            if ($bulan) {
                $query->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan);
            } else {
                $query->whereYear('created_at', $tahun);
            }

            // Clone query sebelum dihitung
            $sertifikatData[$key] = [
                'diterima' => (clone $query)->where('status', 'diterima')->count(),
                'ditolak' => (clone $query)->where('status', 'ditolak')->count(),
                'total' => $query->count(),
            ];
        }

        $queryKelayakan = [
            'finansial' => KelayakanFinansial::query(),
            'operasional' => KelayakanOperasional::query(),
            'pemasaran' => KelayakanPemasaran::query(),
        ];

        foreach ($queryKelayakan as $key => $query) {
            if ($bulan) {
                $query->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan);
            } else {
                $query->whereYear('created_at', $tahun);
            }

            $kelayakanData[$key] = [
                'diterima' => (clone $query)->where('status', 'diterima')->count(),
                'ditolak' => (clone $query)->where('status', 'ditolak')->count(),
                'total' => $query->count(),
            ];
        }

        $totalSertifikat = collect($sertifikatData)->sum('total');
        $totalKelayakan = collect($kelayakanData)->sum('total');


        return view('admin.laporan', compact('totalSertifikat', 'sertifikatData', 'totalKelayakan', 'kelayakanData', 'tahun', 'bulan'));
    }


    public function export(Request $request)
    {
        $format = $request->query('format', 'pdf');
        $tahun = $request->query('tahun', date('Y'));
        $bulan = $request->query('bulan');

        // Buat query dengan filter tahun & bulan
        $querySertifikat = [
            'Sertifikat Halal' => PengajuanHalal::query(),
            'Sertifikat Koki' => PengajuanKoki::query(),
            'Sertifikat Asisten Koki' => PengajuanAsistenKoki::query(),
        ];

        $sertifikatData = [];
        foreach ($querySertifikat as $key => $query) {
            if ($bulan) {
                $query->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan);
            } else {
                $query->whereYear('created_at', $tahun);
            }

            $sertifikatData[$key] = [
                'diterima' => (clone $query)->where('status', 'diterima')->count(),
                'ditolak' => (clone $query)->where('status', 'ditolak')->count(),
                'total' => $query->count(),
            ];
        }

        $queryKelayakan = [
            'finansial' => KelayakanFinansial::query(),
            'operasional' => KelayakanOperasional::query(),
            'pemasaran' => KelayakanPemasaran::query(),
        ];

        $kelayakanData = [];
        foreach ($queryKelayakan as $key => $query) {
            if ($bulan) {
                $query->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan);
            } else {
                $query->whereYear('created_at', $tahun);
            }

            $kelayakanData[$key] = $query->count();
        }

        $totalSertifikat = collect($sertifikatData)->sum('total');
        $totalKelayakan = collect($kelayakanData)->sum();

        // Kirim data ke PDF dengan hasil query yang sudah difilter
        $data = compact('totalSertifikat', 'sertifikatData', 'totalKelayakan', 'kelayakanData', 'tahun', 'bulan');

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan_pdf', $data);
            return $pdf->download('laporan_' . $tahun . '_' . ($bulan ?? 'all') . '.pdf');
        }

        return Excel::download(new LaporanExport($tahun, $bulan), 'laporan_' . $tahun . '_' . ($bulan ?? 'all') . '.' . $format);
    }
}
