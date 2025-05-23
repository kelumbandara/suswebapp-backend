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
        'representorId',
        'announcement',
        'assessmentDate',
        'auditorId',
        'remarks',
        'auditorName',
        'auditExpiryDate',
        'auditStatus',
        'auditScore',
        'gradePeriod',
        'numberOfNonCom',
        'auditFee',
        'auditGrade',
        'documents',
        'createdByUser',
        'responsibleSection',
        'assigneeLevel',

    ];

    protected $casts = [
        'documents' => 'array',
    ];


    protected static function booted()
    {
        static::created(function ($model) {
            $model->referenceNumber = 'EAUD-' . $model->id;

            $model->save();
        });
    }

}
