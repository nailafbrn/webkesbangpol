<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renstra extends Model
{
    protected $table = 'renstras';

    protected $fillable = [
        'title',
        'tahun_mulai',
        'tahun_selesai',
        'file_upload',
        'file_upload_wm',
    ];
}
