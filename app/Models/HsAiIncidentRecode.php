<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsAiIncidentRecode extends Model
{
    use HasFactory;

    protected $table = 'hs_ai_incident_recode';

    protected $fillable = [
        'referenceNumber',
        'createdByUser',
        'division',
        'location',
        'circumstances',
        'imageUrl',
        'typeOfNearMiss',
        'typeOfConcern',
        'factors',
        'causes',
        'incidentDetails',
        'incidentTime',
        'incidentDate',
        'status',
        'severity',
        'assignee',
        'createdUserLevel',
        'responsibleSection'
    ];
}
