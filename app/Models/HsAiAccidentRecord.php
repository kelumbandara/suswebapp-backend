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
        'division',
        'location',
        'department',
        'supervisor',
        'imageUrl',
        'category',
        'subCategory',
        'accidentType',
        'primaryRegion',
        'secondaryRegion',
        'tertiaryRegion',
        'cause',
        'hospital',
        'consultedDoctor',
        'description',
        'status',
        'workPerformance',
        'accessToken',
        'accidentDate',
        'accidentTime',
        'injuryType',
        'severity',
        'assignee',
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
