<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaAiEaActionPlan extends Model
{
     use HasFactory;

    protected $primaryKey = "actionPlanId";


    protected $fillable = [
        'externalAuditId',
        'correctiveOrPreventiveAction',
        'priority',
        'approverId',
        'targetCompletionDate',
        'dueDate',
        'date',
    ];

    public function questionRecode()
    {
        return $this->belongsTo(SaAiExternalAuditRecode::class, 'externalAuditId');
    }
    
}
