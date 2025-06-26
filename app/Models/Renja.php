<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renja extends Model
{
    protected $table = 'renjas';

    protected $fillable = [
        'title',
        'tahun',
        'file_upload',
        'file_upload_wm',
    ];
}
