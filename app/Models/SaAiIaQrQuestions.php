<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaAiIaQrQuestions extends Model
{
    use HasFactory;

    protected $primaryKey = 'queid';

    protected $fillable = [
        'queGroupId',
        'quectionRecoId',
        'colorCode',
        'question',
        'allocatedScore',
    ];

    public function group()
    {
        return $this->belongsTo(SaAiIaQrGroupRecode::class, 'queGroupId');
    }

    public function questionRecode()
    {
        return $this->belongsTo(SaAiIaQuestionRecode::class, 'quectionRecoId');
    }

}
