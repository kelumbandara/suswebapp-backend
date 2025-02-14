<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsOhMrBenefitEntitlement extends Model
{
    use HasFactory;

    protected $primaryKey = 'entitlementId';

    protected $fillable = [
        'benefitId',
        'benefitType',
        'amountValue',
        'totalDaysPaid',
        'amount1stInstallment',
        'dateOf1stInstallment',
        'amount2ndInstallment',
        'dateOf2ndInstallment',
        'ifBenefitReceived',
        'beneficiaryName',
        'beneficiaryAddress',
        'beneficiaryTotalAmount',
        'beneficiaryDate',
        'description',
    ];
    public function benefit()
    {
        return $this->belongsTo(HsOhMrBenefitRequest::class, 'benefitId');
    }

}
