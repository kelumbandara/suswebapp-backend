<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsAiIncidentTypeOfNearMiss extends Model
{
    use HasFactory;
    protected $table = 'hs_ai_incident_type_of_near_miss';
    
    protected $fillable = [
        'type'
    ];
}
