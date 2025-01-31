<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsHrHazardRisk extends Model
{
    use HasFactory;

    protected $fillable = [
        'referenceNumber',
        'categoryName',
        'subCategory',
        'observationType',
        'divisionName',
        'assigneeName',
        'location',
        'subLocation',
        'description',
        'fileUrl',
        'dueDate',
        'condition',
        'riskLevel',
        'unsafeType',
        'status',
        'serverDateAndTime',
        'assigneeLevel',
        'responsibleSection',
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
