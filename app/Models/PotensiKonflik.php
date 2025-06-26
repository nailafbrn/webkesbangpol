<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotensiKonflik extends Model
{
    use HasFactory;
    protected $table = 'potensi_konfliks'; // nama tabel
    protected $fillable = [
        'nama_potensi',
        'kategori',
        'lokasi_kecamatan',
        'lokasi_kelurahan',
        'alamat',
        'tanggal',
        'tingkat_potensi',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',        // atau 'datetime' jika ada waktu
    ];
}
