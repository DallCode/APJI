<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';
    protected $fillable = [
    'id_event', 
    'nama_event', 
    'tanggal', 
    'lokasi', 
    'daftar_hadir', 
    'notulensi', 
    'dokumentasi'
    ];

    protected $primaryKey = 'id_event';
}
