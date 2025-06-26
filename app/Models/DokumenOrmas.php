<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ormas;

class DokumenOrmas extends Model
{
    use HasFactory;
    protected $fillable = [
        'ormas_id',
        'akta_notaris',
        'ahu_skt',
        'npwp',
    ];

    public function ormas()
    {
        return $this->belongsTo(Ormas::class);
    }
}