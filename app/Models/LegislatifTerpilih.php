<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegislatifTerpilih extends Model
{
    use HasFactory;

    protected $fillable = [
        'legislatif_id',
        'jabatan',
    ];

    /**
     * Relasi ke tabel legislatifs (detail caleg)
     */
    public function legislatif()
    {
        return $this->belongsTo(Legislatif::class, 'legislatif_id');
    }
}