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
            $model->referenceNumber = $model->generateReferenceNumber();
        });
    }

    private function generateReferenceNumber()
    {
        $latest = HsAiAccidentRecord::latest()->first();
        $lastId = $latest ? $latest->id : 0;

        return 'ACD-' . ($lastId + 1);
    }

}
