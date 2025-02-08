<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsOhCsMedicineStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicineName',
        'division',
        'inStock',
        'status',
        'lastUpdated',
    ];
}
