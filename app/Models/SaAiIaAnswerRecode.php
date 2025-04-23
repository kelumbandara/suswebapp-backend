<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaAiIaAnswerRecode extends Model
{
    use HasFactory;

    protected $primaryKey = 'answerId';

    protected $table = 'sa_ai_ia_answer_recode';
    protected $fillable = [
        'internalAuditId',
        'questionRecoId',
        'queGroupId',
        'quectionId',
        'rating',
        'score',
        'status',

    ];
    public function questionGroup()
    {
        return $this->belongsTo(SaAiIaQrGroupRecode::class, 'queGroupId');
    }
    public function group()
    {
        return $this->belongsTo(SaAiInternalAuditRecode::class, 'internalAuditId');
    }
    public function question()
    {
        return $this->belongsTo(SaAiIaQrQuestions::class, 'quectionId');
    }

    public function questionRecode()
    {
        return $this->belongsTo(SaAiIaQuestionRecode::class, 'quectionRecoId');
    }
}
