<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelayakanOperasional extends Model
{
    use HasFactory;

    protected $table = 'kelayakan_operasional';

    protected $fillable = [
        'nama_usaha',
        'deskripsi_operasional',
    ];
}
