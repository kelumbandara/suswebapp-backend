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
        'assignee',
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
    protected $casts = [
        'dueDate' => 'datetime',
        'serverDateAndTime' => 'datetime',
        ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->referenceNumber = $model->generateReferenceNumber();
        });
    }

    private function generateReferenceNumber()
    {
        $latest = HsHrHazardRisk::latest()->first();
        $lastId = $latest ? $latest->id : 0;

        return 'EHS-' . ($lastId + 1);
    }

}
