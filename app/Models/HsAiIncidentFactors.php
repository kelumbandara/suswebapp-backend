<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsAiIncidentFactors extends Model
{
    use HasFactory;

    protected $table = 'hs_ai_incident_factors';
    
    protected $fillable = [
        'factorName',
    ];
}
