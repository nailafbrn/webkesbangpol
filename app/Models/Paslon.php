<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paslon extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_urut',
        'jenis_pemilu',
        'tahun_pemilu',
        'partai_pengusung',
        'total_suara',
        'visi',
        'misi',
        'capres_nama',
        'capres_foto',
        'capres_tempat_lahir',
        'capres_tanggal_lahir',
        'capres_jenis_kelamin',
        'capres_riwayat_pendidikan',
        'capres_riwayat_pekerjaan',
        'cawapres_nama',
        'cawapres_foto',
        'cawapres_tempat_lahir',
        'cawapres_tanggal_lahir',
        'cawapres_jenis_kelamin',
        'cawapres_riwayat_pendidikan',
        'cawapres_riwayat_pekerjaan',
    ];
}