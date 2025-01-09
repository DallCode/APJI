<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanKoki extends Model
{
    // Nama tabel
    protected $table = 'detail_pengajuan_koki';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'id_detail',
        'id_pengguna',  // Jangan masukkan 'id_detail' jika auto-increment
        'nama_lengkap',
        'pengalaman_kerja',
        'pendidikan_terakhir',
        'status',
    ];

    // Jika tabel ini memiliki kolom created_at dan updated_at, maka ini tetap true.
    public $timestamps = false; // Atur menjadi true jika tabel memiliki timestamps.

    public function pengguna()
    {
        return $this->belongsTo(DataPengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
