<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HazardRisk extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_id', // Include the new reference_id field
        'division',
        'location',
        'subLocation',
        'category',
        'subCategory',
        'observationType',
        'description',
        'riskLevel',
        'unsafeActOrCondition',
        'status',
        'created_by_user',
        'created_date',
        'dueDate',
        'assignee',
    ];

    protected $casts = [
        'created_date' => 'datetime',
        'dueDate' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($hazardRisk) {
            // Generate custom reference_id based on max id
            $maxId = HazardRisk::max('id') + 1;
            $hazardRisk->reference_id = 'EHS-' . $maxId;
        });
    }
}

