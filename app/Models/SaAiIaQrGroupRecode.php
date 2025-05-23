<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaAiIaQrGroupRecode extends Model
{
    use HasFactory;

    protected $primaryKey = 'queGroupId';

    protected $fillable = [

        'questionRecoId',
        'groupName',

    ];

    public function questionRecode()
    {
        return $this->belongsTo(SaAiIaQuestionRecode::class, 'questionRecoId');
    }




}
