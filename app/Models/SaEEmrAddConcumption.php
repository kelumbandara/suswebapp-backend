<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaEEmrAddconsumption extends Model
{
    use HasFactory;

    protected $primaryKey = 'consumptionId';

    protected $fillable = [
        'envirementId',
        'category',
        'source',
        'unit',
        'quantity',
        'amount',
        'ghgInTonnes',
        'scope',
        'methodOfTracking',
        'usageType',
        'doYouHaveREC',
        'description',

    ];

    public function impact()
    {
        return $this->belongsTo(SaEEnvirementManagementRecode::class, 'envirementId');
    }
}
