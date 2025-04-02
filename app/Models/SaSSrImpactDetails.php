<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaSSrImpactDetails extends Model
{
    use HasFactory;
    protected $primaryKey = 'impactId';
    protected $fillable = [
        'sdgId',
        'impactType',
        'unit',
        'value',
    ];

    public function incident()
    {
        return $this->belongsTo(SaSSdgReportingRecode::class, 'sdgId');
    }
}
