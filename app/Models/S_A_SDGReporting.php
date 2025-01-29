<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class S_A_SDGReporting extends Model
{
    use HasFactory;

    protected $table = 's_a_s_d_g_reportings';

    protected $fillable = [
        'ReferenceNumber',
        'title',
        'location',
        'division',
        'pillar',
        'timeLine',
        'materialType',
        'materialIssue',
        'sdg',
        'additionalSDGs',
        'griAndSubStandards',
        'organiser',
        'volunteersParticipants',
        'priority',
        'contributing',
        'image_path',
    ];

    public function impactDetails()
    {
        return $this->hasMany(S_A_SDGImpactDetails::class);
    }
    protected static function booted()
    {
        static::creating(function ($sdgReporting) {
            $maxId                       = S_A_SDGReporting::max('id') + 1;
            $sdgReporting->referenceNumber = 'SDG-' . $maxId;
        });
    }
}
