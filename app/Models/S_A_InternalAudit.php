<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class S_A_InternalAudit extends Model
{
    use HasFactory;
    protected $table = 's_a_internal_audits';

    protected $fillable = [
        'referenceNumber',
        'division',
        'department',
        'auditTitle',
        'auditType',
        'isNotSupplier',
        'supplierType',
        'factoryLiNo',
        'higgId',
        'zdhcId',
        'processType',
        'factoryName',
        'factoryAddress',
        'factoryContact',
        'designation',
        'email',
        'contactNumber',
        'auditDate',
        'auditee',
        'approver',
        'status',
        'dateApproval',
        'description',
    ];
    protected static function booted()
    {
        static::creating(function ($internalAudit) {
            $maxId                       = S_A_InternalAudit::max('id') + 1;
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
}
