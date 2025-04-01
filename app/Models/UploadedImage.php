<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadedImage extends Model
{
    protected $fillable = [
        'title',
        'description',
        'path',
        'file_type',
        'size'
    ];
}
