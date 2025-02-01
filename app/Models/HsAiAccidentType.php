<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsAiAccidentType extends Model
{
    use HasFactory;

    protected $table = 'hs_ai_accident_types';

    protected $fillable = [
        'accidentTypeName',
    ];
    
}
