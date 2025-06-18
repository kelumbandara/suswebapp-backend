<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaRrCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoryName',
    ];
}
