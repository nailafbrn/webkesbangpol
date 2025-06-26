<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iku extends Model
{
    protected $table = 'ikus';

    protected $fillable = [
        'title',
        'tahun',
        'file_upload',
        'file_upload_wm',
    ];
}
