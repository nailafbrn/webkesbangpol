<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UkurKerja extends Model
{
    protected $table = 'ukurkerjas';

    protected $fillable = [
        'title',
        'tahun',
        'file_upload',
        'file_upload_wm',
    ];
}
