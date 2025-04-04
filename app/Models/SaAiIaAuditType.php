<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaAiIaAuditType extends Model
{
    use HasFactory;

    protected $fillable = [
        'auditTypeName',
    ];
}
