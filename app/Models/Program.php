<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $fillable = [
        'bidang_id',
        'nama_program',
    ];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

        public function galeris()
    {
        return $this->hasMany(Galeri::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
