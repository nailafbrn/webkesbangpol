<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PengurusOrmas;
use App\Models\DokumenOrmas;

class Ormas extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_organisasi',
        'alamat',
        'bidang',
        'sumber_data',
    ];

    public function pengurus()
    {
        return $this->hasMany(PengurusOrmas::class);
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenOrmas::class);
    }

    public function pengurusedit()
    {
        return $this->hasOne(PengurusOrmas::class);
    }

        public function dokumenedit()
    {
        return $this->hasOne(DokumenOrmas::class);
    }
}