<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OhMiPiMedicineInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'referenceNumber',
        'approverId',
        'inventoryNumber',
        'requestedBy',
        'requestQuantity',
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
        'issuedQuantity',
        'approvedBy',
        'status',
        'responsibleSection',
        'assigneeLevel',
        'createdByUser',
    ];

    

    public function disposals()
{
    return $this->hasMany(OhMiPiMiDisposal::class, 'inventoryId', 'id');
}
}
