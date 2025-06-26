<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'program_id', 'gambar_upload'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
