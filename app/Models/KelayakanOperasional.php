<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelayakanOperasional extends Model
{
    use HasFactory;

    protected $table = 'kelayakan_operasional';

    protected $primaryKey = 'id_operasional';

    protected $fillable = [
        'id_pengguna',
        'nama_usaha',
        'deskripsi_operasional',
        'file',
        'status',
    ];

    // Relasi ke pengajuan_sertifikat
    public function pengguna()
    {
        return $this->belongsTo(DataPengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
