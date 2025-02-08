<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsOhMiMedicineName extends Model
{
    use HasFactory;

    protected $table = 'hs_oh_mi_medicine_names';

    protected $fillable = [
        'MedicineName',
        'GenericName',
        'DosageStrength',
        'Form',
        'MedicineType',
    ];
}
