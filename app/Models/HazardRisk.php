<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HazardRisk extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_id',
        'division',
        'locationOrDepartment', 
        'subLocation',
        'category',
        'subCategory',
        'observationType',
        'description',
        'riskLevel',
        'unsafeActOrCondition',
        'status',
        'createdByUser',
        'createdDate',
        'dueDate',
        'assignee',
        'document',
    ];

    protected $casts = [
        'created_date' => 'datetime',
        'dueDate' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($hazardRisk) {
            $maxId = HazardRisk::max('id') + 1;
            $hazardRisk->reference_id = 'EHS-' . $maxId;
        });
    }
}

