<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsHrCategory extends Model
{
    use HasFactory;

    protected $table = 'hs_hr_categories';

    protected $fillable = [
        'categoryName',
        'subCategory',
        'observationType',
    ];

}
