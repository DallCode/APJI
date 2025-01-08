<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelayakanFinansial extends Model
{
    use HasFactory;

    protected $table = 'kelayakan_finansial';

    protected $fillable = [
        'nama_usaha',
        'laporan_keuangan',
    ];
}
