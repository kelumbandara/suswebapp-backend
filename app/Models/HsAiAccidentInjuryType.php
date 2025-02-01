<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsAiAccidentInjuryType extends Model
{
    use HasFactory;

    protected $table = 'hs_ai_accident_injury_types';

    protected $fillable = [
        'injuryType',
    ];

}

