<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OhMiPiMedicineInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'referenceNumber',
        'medicineName',
        'genericName',
        'dosageStrength',
        'form',
        'medicineType',
        'requestedDate',
        'supplierName',
        'supplierContactNumber',
        'supplierEmail',
        'supplierType',
        'location',
        'manufacturingDate',
        'expiryDate',
        'deliveryDate',
        'deliveryQuantity',
        'deliveryUnit',
        'purchaseAmount',
        'thresholdLimit',
        'invoiceDate',
        'invoiceReference',
        'manufacturerName',
        'batchNumber',
        'reorderThreshold',
        'usageInstruction',
        'division',
        'requestedBy',
        'approvedBy',
        'status',
        'responsibleSection',
        'assigneeLevel',
        'createdByUser',
    ];

    protected static function booted()
    {
        static::created(function ($model) {
            $model->referenceNumber = 'MED-' . $model->id;

            $model->save();
        });
    }

    public function disposals()
{
    return $this->hasMany(OhMiPiMiDisposal::class, 'inventoryId', 'id');
}
}
