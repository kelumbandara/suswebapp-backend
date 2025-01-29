<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class S_A_SDGImpactDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        's_a_s_d_g_reporting_id',
        'impact_type',
        'unit',
        'value',
    ];

    public function s_a_s_d_g_reporting()
    {
        return $this->belongsTo(S_A_SDGReporting::class);
    }
}
