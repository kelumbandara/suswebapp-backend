<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsAiAccidentCategory extends Model
{
    use HasFactory;

    protected $table = 'hs_ai_accident_categories';

    protected $fillable = [
        'categoryName',
    ];

}
