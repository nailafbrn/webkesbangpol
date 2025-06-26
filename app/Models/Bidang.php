<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;
    protected $fillable = ['no_bidang', 'nama_bidang'];


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

        public function landasanhukums()
    {
        return $this->hasMany(Program::class);
    }

}
