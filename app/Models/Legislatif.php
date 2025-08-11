<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legislatif extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_urut',
        'nama_lengkap', // Pastikan ini ada
        'tempat_lahir',
        'riwayat_pendidikan',
        'riwayat_pekerjaan',
        'jenis_kelamin',
        'nama_partai',
        'dapil',
        'suara_sah',
    ];
}
