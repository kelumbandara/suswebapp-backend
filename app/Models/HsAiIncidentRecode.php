<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsAiIncidentRecode extends Model
{
    use HasFactory;

    protected $table = 'hs_ai_incident_recodes';

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

    protected static function booted()
    {
        static::creating(function ($model) {
            // Set a temporary reference number before the record is inserted
            $model->referenceNumber = 'ICD-PENDING'; // Use a temporary value to avoid SQL error
        });

        static::created(function ($model) {
            // Now that the record has an ID, update the referenceNumber
            $model->referenceNumber = 'ICD-' . $model->id;
            $model->save(); // Save again to update the referenceNumber
        });
    }
}
