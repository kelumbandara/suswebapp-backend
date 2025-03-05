<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsOhMiMedicineRequest extends Model
{
    use HasFactory;

    protected $table = 'hs_oh_mi_medicine_requests';

    protected $fillable = [
        'referenceNumber',
        'medicineName',
        'genericName',
        'division',
        'approverId',
        'requestQuantity',
        'inventoryNumber',
        'requestedDate',
        'status',
        'responsibleSection',
        'assigneeLevel',
        'createdByUser',
    ];
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->referenceNumber = $model->generateReferenceNumber();
        });
    }

    private function generateReferenceNumber()
    {
        $latest = HsOhMiMedicineRequest::latest()->first();
        $lastId = $latest ? $latest->id : 0;

        return 'MED-' . ($lastId + 1);
    }
}
