<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaAiIaInternalAuditee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];
}
