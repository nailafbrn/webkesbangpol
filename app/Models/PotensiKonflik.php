<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotensiKonflik extends Model
{
    use HasFactory;
    
    protected $table = 'potensi_konfliks';
    
    protected $fillable = [
        'no',
        'nama_potensi',
        'kategori',
        'lokasi_kecamatan',
        'lokasi_kelurahan',
        'alamat',
        'tanggal',
        'tingkat_potensi',
        'deskripsi',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];
    
    public function getTingkatColorAttribute()
    {
        return match($this->tingkat_potensi) {
            'tinggi' => 'danger',
            'sedang' => 'warning',
            default => 'success'
        };
    }
    
    public function getStatusColorAttribute()
    {
        return $this->status == 'aktif' ? 'danger' : 'success';
    }
}