<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelayakanFinansial extends Model
{
    use HasFactory;

    protected $table = 'kelayakan_finansial';

    protected $primaryKey = 'id_finansial';

    protected $fillable = [
        'id_pengguna',
        'nama_usaha',
        'laporan_keuangan',
        'file',
        'status',
    ];

     // Relasi ke pengajuan_sertifikat
     public function pengguna()
     {
         return $this->belongsTo(DataPengguna::class, 'id_pengguna', 'id_pengguna');
     }
}
