<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsOhMiMedicineRequest extends Model
{
    use HasFactory;

    protected $table = 'hs_oh_mi_medicine_requests';

    protected $fillable = [
        'MedicineName',
        'GenericName',
        'division',
        'Approver',
        'ReferenceNumber',
        'InventoryNumber',
        'RequestedDate',
        'status',
        'responsibleSection',
        'assigneeLevel',
        'createdByUser',
    ];
}
