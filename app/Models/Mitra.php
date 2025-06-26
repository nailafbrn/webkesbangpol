<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_mitra',
        'logo_lembaga',
        'nama_lembaga',
        'alamat',
        'deskripsi',
        'ketua',
        'foto_ketua',
        'kontak',
    ];
}
