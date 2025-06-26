<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ormas;


class PengurusOrmas extends Model
{
    use HasFactory;
    protected $fillable = [
        'ormas_id',
        'jabatan',
        'nama',
        'no_telepon',
    ];

    public function ormas()
    {
        return $this->belongsTo(Ormas::class);
    }
}