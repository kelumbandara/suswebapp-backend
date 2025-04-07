<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaAiInternalAuditRecode extends Model
{
    use HasFactory;

    protected $fillable = [
        'referenceNumber',
        'division',
        'auditTitle',
        'auditType',
        'department',
        'isAuditScheduledForSupplier',
        'supplierType',
        'factoryLicenseNo',
        'higgId',
        'zdhcId',
        'processType',
        'status',
        'factoryName',
        'factoryAddress',
        'factoryContactPerson',
        'factoryContactNumber',
        'factoryEmail',
        'designation',
        'description',
        'auditeeId',
        'approverId',
        'auditDate',
        'dateForApproval',
        'responsibleSection',
        'assigneeLevel',
        'createdByUser',

    ];

    protected $casts = [
        'department' => 'array',
        'auditTitle' => 'array',
        'isAuditScheduledForSupplier' => 'boolean',
    ];

    protected static function booted()
    {
        static::created(function ($model) {
            $model->referenceNumber = 'IAUD-' . $model->id;

            $model->save();
        });
    }
}
