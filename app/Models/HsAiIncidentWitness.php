<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsAiIncidentWitness extends Model
{
    use HasFactory;

    protected $table = 'hs_ai_incident_witnesses';

    protected $primaryKey = 'witnessId';

    protected $fillable = [
        'incidentId',
        'employeeId',
        'name',
        'division',
        'department',
    ];


    public function incident()
    {
        return $this->belongsTo(HsAiIncidentRecode::class, 'incidentId');
    }
}
