<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HazardRisk extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'reference',
        'division',
        'location',
        'sub_location',
        'category',
        'sub_category',
        'observation_type',
        'description',
        'risk_level',
        'unsafe_act_or_condition',
        'status',
        'created_by_user',
        'created_date',
        'due_date',
        'assignee',
    ];

    protected $casts = [
        'created_date' => 'datetime',
        'due_date' => 'datetime',

    ];
    protected static function booted()
    {
        static::creating(function ($hazardRisk) {
            $hazardRisk->reference = 'EHS-' . (HazardRisk::max('id') + 1);  // auto-increment ID based reference
        });
    }
}
