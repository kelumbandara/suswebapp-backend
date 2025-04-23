<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaEEmrAddConsumption extends Model
{
    use HasFactory;

    protected $primaryKey = 'consumptionId';

    protected $table = 'sa_e_emr_add_consumption';

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
