<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaRrFunction extends Model
{
    use HasFactory;

    protected $fillable = [
        'functionName',
    ];
}
