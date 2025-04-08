<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaAiIaQuestionRecode extends Model
{
    use HasFactory;

    protected $fillable = [
        'referenceNumber',
        'name',
        'description',
        'status',
        'createdByUser',
        'responsibleSection',
        'assigneeLevel'

    ];
    protected static function booted()
    {
        static::created(function ($model) {
            $model->referenceNumber = 'IAQ-' . $model->id;

            $model->save();
        });
    }
 
}
