<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaEEnvirementManagementRecode extends Model
{
    use HasFactory;

    protected $fillable = [
        'referenceNumber',
        'totalWorkForce',
        'numberOfDaysWorked',
        'totalProuctProducedPcs',
        'totalProuctProducedkg',
        'division',
        'year',
        'month',
        'reviewerId',
        'approverId',
        'area',
        'status',
        'responsibleSection',
        'assigneeLevel',
        'createdByUser',
    ];

    protected static function booted()
    {
        static::created(function ($model) {
            $model->referenceNumber = 'ENV-' . $model->id;

            $model->save();
        });
    }
    }
