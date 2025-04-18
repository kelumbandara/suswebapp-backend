<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaETargetSettingRecode extends Model
{
    use HasFactory;

    protected $fillable = [
        'referenceNumber',
        'division',
        'department',
        'category',
        'source',
        'baselineConsumption',
        'ghgEmission',
        'problem',
        'documents',
        'responsibleId',
        'approverId',
        'action',
        'possibilityCategory',
        'opertunity',
        'implementationCost',
        'expectedSavings',
        'targetGHGReduction',
        'costSavings',
        'implementationTime',
        'paybackPeriod',
        'projectLifespan',
        'status',
        'responsibleSection',
        'assigneeLevel',
        'createdByUser',
    ];

    protected $casts = [
        'documents' => 'array',
    ];

    protected static function booted()
    {
        static::created(function ($model) {
            $model->referenceNumber = 'ETS-' . $model->id;

            $model->save();
        });
    }
}
