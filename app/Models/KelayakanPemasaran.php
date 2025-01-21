<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelayakanPemasaran extends Model
{
    use HasFactory;

    protected $table = 'kelayakan_pemasaran';

    protected $primaryKey = 'id_pemasaran';

    protected $fillable = [
        'id_pengguna',
        'nama_usaha',
        'strategi_pemasaran',
        'file',
    ];

    // Relasi ke pengajuan_sertifikat
    public function pengguna()
    {
        return $this->belongsTo(DataPengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
