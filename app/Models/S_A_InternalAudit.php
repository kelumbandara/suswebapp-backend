<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class S_A_InternalAudit extends Model
{
    use HasFactory;
    protected $table = 's_a_internal_audits';


    protected $fillable = [
        'reference_id',
        'division',
        'department',
        'audit_title',
        'audit_type',
        'is_supplier_audit',
        'supplier_type',
        'factory_license_no',
        'higg_id',
        'zdhc_id',
        'process_type',
        'factory_name',
        'factory_address',
        'factory_contact_person',
        'designation',
        'email',
        'contact_number',
        'audit_date',
        'auditee',
        'approver',
        'approval_date',
        'description',
    ];
    protected static function booted()
    {
        static::creating(function ($internalAudit) {
            $maxId = S_A_InternalAudit::max('id') + 1;
            $internalAudit->reference_id = 'AUD-' . $maxId;
        });
    }
}
