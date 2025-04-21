<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaCmCmrCommercialName extends Model
{
    use HasFactory;

    protected $fillable = [
        'commercialName',
    ];
}
