<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class S_A_ExternalAudit extends Model
{
    use HasFactory;

    protected $table = 's_a_external_audits';

    protected $fillable = [
    'referenceNumber',
    'auditorName',
    'auditType',
    'auditCategory',
    'customer',
    'auditStandard',
    'auditFirm',
    'division',
    'representative',
    'auditDate',
    'expiryDate',
    'approver',
    'status',
    'announcement',
    'dateApproval',
    'description',
    'lapsedStatus',
    'auditStatus',
    ];
    protected static function booted()
    {
        static::creating(function ($internalAudit) {
            $maxId                       = S_A_ExternalAudit::max('id') + 1;
            $internalAudit->referenceNumber = 'AUD-' . $maxId;
        });
    }

    public function setAuditDateAttribute($value)
    {
        $this->attributes['auditDate'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setDateApprovalAttribute($value)
    {
        $this->attributes['dateApproval'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getAuditDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getDateApprovalAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

}
