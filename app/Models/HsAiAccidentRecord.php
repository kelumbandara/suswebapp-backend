<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsAiAccidentRecord extends Model
{
    use HasFactory;

    protected $table = 'hs_ai_accident_records';

    protected $fillable = [
        'referenceNumber',
        'createdByUser',
        'division',
        'location',
        'department',
        'supervisorName',
        'imageUrl',
        'category',
        'subCategory',
        'accidentType',
        'affectedPrimaryRegion',
        'affectedSecondaryRegion',
        'affectedTertiaryRegion',
        'injuryCause',
        'rootCause',
        'consultedHospital',
        'consultedDoctor',
        'description',
        'status',
        'workPerformed',
        'actionTaken',
        'accidentDate',
        'accidentTime',
        'reportedDate',
        'injuryType',
        'severity',
        'assignee',
        'createdUserlevel',
        'responsiblesection',
        'expectedDate',
        'expectedTime',
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
