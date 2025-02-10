<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsOhMrBenefitDocument extends Model
{
    use HasFactory;

    protected $primaryKey = 'personId';
    
    protected $fillable = [
        'benefitRequestId',
        'documentType',
        'document',
    ];
    public function benefit()
    {
        return $this->belongsTo(HsOhMrBenefitRequest::class, 'benefitRequestId');
    }

}
