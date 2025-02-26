<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageSave extends Model
{
    use HasFactory;

    protected $fillable = [
        'fileName',
        'filePath',
    ];
}
