<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaETsCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoryName',
        'possibilityCategory',
        'opportunity',
    ];

}
