<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanAkip extends Model
{
    protected $table = 'lakips';

    protected $fillable = [
        'title',
        'tahun',
        'file_upload',
        'file_upload_wm',
    ];
}
