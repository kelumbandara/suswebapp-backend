<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaSSdgReportingRecode extends Model
{
    use HasFactory;
    protected $fillable = [
        'referenceNumber',
        'title',
        'location',
        'division',
        'pillars',
        'timeLines',
        'status',
        'materialityType',
        'materialityIssue',
        'sdg',
        'additionalSdg',
        'alignmentSdg',
        'griStandards',
        'organizer',
        'volunteer',
        'priority',
        'contributing',
        'documents',
        'responsibleSection',
        'assigneeLevel',
        'createdByUser',
    ];

    protected $casts = [
        'pillars' => 'array',
        'materialityType' => 'array',
        'materialityIssue' => 'array',
        'additionalSdg' => 'array',
        'documents' => 'array',
    ];

    protected static function booted()
    {
        static::created(function ($model) {
            $model->referenceNumber = 'SDG-' . $model->id;

            $model->save();
        });
    }
}
