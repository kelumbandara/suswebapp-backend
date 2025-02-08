<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsOhMiMnMedicineType extends Model
{
    use HasFactory;

    protected $table = 'hs_oh_mi_mn_medicine_types';
    protected $fillable = [
        'MedicineType',
    ];
}
