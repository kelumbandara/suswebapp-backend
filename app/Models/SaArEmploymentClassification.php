<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaArEmploymentClassification extends Model
{
    use HasFactory;
     protected $fillable = [
        'employmentClassificationName',
    ];
}
