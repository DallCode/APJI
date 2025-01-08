<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanAsistenKoki extends Model
{
    // Nama tabel
    protected $table = 'detail_pengajuan_asisten_koki';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'id_detail',
        'id_pengajuan',
        'nama_lengkap',
        'keahlian_khusus',
        'surat_pengantar',
    ];

    // Jika tabel ini memiliki kolom created_at dan updated_at, maka ini tetap true.
    public $timestamps = false; // Atur menjadi true jika tabel memiliki timestamps.

     // Relasi ke pengajuan_sertifikat
    //  public function pengajuan()
    //  {
    //      return $this->belongsTo(PengajuanSertifikat::class, 'id_pengajuan', 'id_pengajuan');
    //  }
}
