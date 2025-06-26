<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strukturor extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'jabatan',
        'nip',
        'golongan',
        'pangkat',
        'foto_profile',
    ];
}
