<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanHalal extends Model
{
    // Nama tabel
    protected $table = 'detail_pengajuan_halal';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'id_detail',
        'id_pengguna',
        'nama_usaha',
        'alamat_usaha',
        'jenis_usaha',
        'nama_produk',
        'status',
    ];

    // Jika tabel ini memiliki kolom created_at dan updated_at, maka ini tetap true.
    public $timestamps = false; // Atur menjadi true jika tabel memiliki timestamps.

     // Relasi ke pengajuan_sertifikat
     public function pengguna()
     {
         return $this->belongsTo(DataPengguna::class, 'id_pengguna', 'id_pengguna');
     }
}
