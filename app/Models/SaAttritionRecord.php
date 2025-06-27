<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaAttritionRecord extends Model
{
    use HasFactory;

     protected $fillable = [
        'referenceNumber',
        'employeeName',
        'employeeId',
        'countryName',
        'state',
        'resignedDate',
        'relievedDate',
        'division',
        'gender',
        'designation',
        'department',
        'perDaySalary',
        'dateOfJoin',
        'employmentClassification',
        'employmentType',
        'isHostelAccess',
        'isWorkHistory',
        'resignationType',
        'resignationReason',
        'servicePeriod',
        'tenureSplit',
        'isNormalResignation',
        'remark',
        'status',
        'createdByUser',
        'updatedBy',
        'rejectedBy',
        'inprogressBy',
        'approvedBy',
    ];

     protected $casts = [
        'isHostelAccess' => 'boolean',
        'isWorkHistory' => 'boolean',
        'isNormalResignation' => 'boolean',
        'countryName' => 'array',

    ];

        protected static function booted()
    {
        static::created(function ($model) {
            $model->referenceNumber = 'ATR-' . $model->id;

            $model->save();
        });
    }
}
