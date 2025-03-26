<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Laporan Tahun {{ request('tahun') }} - Bulan {{ request('bulan') ?: 'Semua' }}</h2>
    <p>Total Sertifikat: {{ $totalSertifikat }}</p>
    <p>Total Kelayakan: {{ $totalKelayakan }}</p>
</body>
</html>
