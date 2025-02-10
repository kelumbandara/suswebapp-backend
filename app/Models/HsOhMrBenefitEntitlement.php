<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsOhMrBenefitEntitlement extends Model
{
    use HasFactory;

    protected $primaryKey = 'entitlementId';

    protected $fillable = [
        'benefitRequestId',
        'benefitType',
        'amountValue',
        'totalDaysPaid',
        'amount1stInstallment',
        'dateOf1stInstallment',
        'amount2ndInstallment',
        'dateOf2ndInstallment',
        'ifBenefitReceived',
        'benefitName',
        'benefitAddress',
        'benefitTotalAmount',
        'benefitDate',
        'description',
    ];
    public function entitlement()
    {
        return $this->belongsTo(HsOhMrBenefitRequest::class, 'benefitRequestId');
    }
}
