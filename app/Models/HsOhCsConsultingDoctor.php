<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsOhCsConsultingDoctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctorName',
    ];

}
