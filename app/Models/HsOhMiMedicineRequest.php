<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsOhMiMedicineRequest extends Model
{
    use HasFactory;

    protected $table = 'hs_oh_mi_medicine_requests';

    protected $fillable = [
        'medicineName',
        'genericName',
        'division',
        'approver',
        'referenceNumber',
        'inventoryNumber',
        'requestedDate',
        'status',
        'responsibleSection',
        'assigneeLevel',
        'createdByUser',
    ];
}
