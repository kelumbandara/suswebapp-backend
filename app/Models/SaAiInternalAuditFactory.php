<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaAiInternalAuditFactory extends Model
{
    use HasFactory;

    protected $fillable = [
        'factoryName',
        'factoryAddress',
        'factoryContactNumber',
        'factoryEmail',
        'designation',
        'factoryContactPersonId',
        'factoryContactPersonName'
    ];
}
