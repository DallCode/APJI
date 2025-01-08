<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelayakanPemasaran extends Model
{
    use HasFactory;

    protected $table = 'kelayakan_pemasaran';

    protected $fillable = [
        'nama_usaha',
        'strategi_pemasaran',
    ];
}
