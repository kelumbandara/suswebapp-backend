<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaAiIaActionPlan extends Model
{
    use HasFactory;

    protected $primaryKey = "acctionPlanId";

    protected $fillable = [
        'internalAuditId',
        'correctiveOrPreventiveAction',
        'priority',
        'approverId',
        'targetCompletionDate',
        'dueDate',
        'date',

    ];
    public function questionRecode()
    {
        return $this->belongsTo(SaAiInternalAuditRecode::class, 'internalAuditId');
    }


}
