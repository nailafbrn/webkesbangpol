<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bidang;
use App\Models\Program;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'bidang_id',
        'program_id',
        'image',
        'title',
        'slug',
        'content',
        'created_at',
        'update_at'
    ];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function program()
    {
        return $this->belongsTo(program::class);
    }
}


