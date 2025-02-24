<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsHrHazardRisk extends Model
{
    use HasFactory;
    protected $table = 'hs_hr_hazard_risks';

    protected $fillable = [
        'referenceNumber',
        'category',
        'subCategory',
        'observationType',
        'division',
        'assigneeId',
        'locationOrDepartment',
        'subLocation',
        'description',
        'documents',
        'dueDate',
        'condition',
        'riskLevel',
        'unsafeActOrCondition',
        'status',
        'serverDateAndTime',
        'assigneeLevel',
        'responsibleSection',
        'createdByUser',
    ];



    protected static function booted()
    {
        static::created(function ($model) {
            $model->referenceNumber = 'EHS-' . $model->id;

            $model->save();
        });
    }

}
