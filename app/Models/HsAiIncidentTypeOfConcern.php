<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsAiIncidentTypeOfConcern extends Model
{
    use HasFactory;

    protected $table = 'hs_ai_incident_type_of_concern';

    protected $fillable = [
        'typeConcerns',
    ];
}
