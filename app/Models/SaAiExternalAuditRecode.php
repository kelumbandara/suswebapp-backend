<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaAiExternalAuditRecode extends Model
{
    use HasFactory;

    protected $fillable = [
        'referenceNumber',
        'auditType',
        'auditCategory',
        'auditStandard',
        'customer',
        'auditFirm',
        'division',
        'status',
        'auditDate',
        'approvalDate',
        'approverId',
        'representor',
        'announcement',
        'assessmentDate',
        'auditorId',
        'remarks',
        'auditorName',
        'expiryDate',
        'auditStatus',
        'auditScore',
        'gradePeriod',
        'numberOfNonCom',
        'auditFee',
        'auditGrade',
        'document',
        'createdByUser',
        'responsibleSection',
        'assigneeLevel',

    ];

    protected static function booted()
    {
        static::created(function ($model) {
            $model->referenceNumber = 'AUD-' . $model->id;

            $model->save();
        });
    }

}
