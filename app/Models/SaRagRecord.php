<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaRagRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'referenceNumber',
        'employeeType',
        'employeeId',
        'employeeName',
        'division',
        'dateOfJoin',
        'designation',
        'department',
        'gender',
        'age',
        'dateOfBirth',
        'servicePeriod',
        'tenureSplit',
        'sourceOfHiring',
        'function',
        'reportingManager',
        'country',
        'state',
        'origin',
        'category',
        'discussionSummary',
        'remark',
        'employmentType',
        'rag',
        'status',
        'createdByUser',
        'updatedBy',
        'rejectedBy',
        'inprogressBy',
        'approvedBy',
    ];

    protected static function booted()
    {
        static::created(function ($model) {
            $model->referenceNumber = 'RAG-' . $model->id;

            $model->save();
        });
    }
}
