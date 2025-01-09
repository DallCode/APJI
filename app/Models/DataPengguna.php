<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPengguna extends Model
{
    protected $table = 'data_pengguna';

    protected $fillable = [
        'id_pengguna',
        'email',
        'tipe_member',
        'nama_usaha',
        'alamat',
        'provinsi',
        'kota',
        'kecamatan',
        'kode_pos',
        'no_telp',
        'nama_pemilik',
        'no_ktp',
        'no_sku',
        'no_npwp',
        'k_usaha',
        'j_usaha',
    ];

    public $timestamps = false; // Sesuaikan jika tabel memiliki kolom created_at dan updated_at
    
}

