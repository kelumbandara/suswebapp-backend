<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsAiIncidentPeople extends Model
{
    use HasFactory;

    protected $table = 'hs_ai_incident_people';

    protected $primaryKey = 'personId';

    protected $fillable = [
        'incidentId',
        'personType',
        'employeeId',
        'name',
        'gender',
        'age',
        'dateOfJoin',
        'employmentDuration',
        'industryExperience',
        'designation',
    ];

    public function incident()
    {
        return $this->belongsTo(HsAiIncidentRecode::class, 'incidentId');
    }
}
