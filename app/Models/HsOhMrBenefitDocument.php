<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsOhMrBenefitDocument extends Model
{
    use HasFactory;

    protected $primaryKey = 'documentId';

    protected $fillable = [
        'benefitRequestId',
        'documentType',
        'document',
    ];
    public function benefitDocument()
    {
        return $this->belongsTo(HsOhMrBenefitRequest::class, 'benefitRequestId');
    }

}
