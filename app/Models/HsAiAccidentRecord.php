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
        'evidence',
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
        'assigneeId',
        'createdUserlevel',
        'responsiblesection',
        'expectedDate',
        'expectedTime',
    ];

    protected $casts = [
        'evidence' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->referenceNumber = 'ACD-PENDING';
        });

        static::created(function ($model) {
            $model->referenceNumber = 'ACD-' . $model->id;
            $model->save();
        });
    }

}
