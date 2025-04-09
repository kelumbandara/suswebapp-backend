<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaEEmrAddConcumption extends Model
{
    use HasFactory;

    protected $primaryKey = 'concumptionsId';

    protected $fillable = [
        'envirementId',
        'category',
        'source',
        'unit',
        'quentity',
        'amount',
        'ghgInTonnes',
        'scope',
        'methodeOfTracking',
        'usageType',
        'doYouHaveREC',
        'description',

    ];

    public function impact()
    {
        return $this->belongsTo(SaEEnvirementManagementRecode::class, 'envirementId');
    }
}
