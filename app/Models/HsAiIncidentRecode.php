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
        'evidence',
        'typeOfNearMiss',
        'typeOfConcern',
        'factors',
        'causes',
        'incidentDetails',
        'incidentTime',
        'incidentDate',
        'status',
        'severity',
        'assigneeId',
        'createdUserLevel',
        'responsibleSection',
    ];

    protected $casts = [
        'evidence' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->referenceNumber = 'ICD-PENDING';
        });

        static::created(function ($model) {
            $model->referenceNumber = 'ICD-' . $model->id;
            $model->save();
        });
    }
}
