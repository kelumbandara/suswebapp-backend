<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OhMiPiMiDisposal extends Model
{
    use HasFactory;

    protected $table = 'oh_mi_pi_mi_disposals';

    protected $primaryKey = 'disposalId';


    protected $fillable = [
        'inventoryId',
        'disposalDate',
        'availableQuantity',
        'disposalQuantity',
        'contractor',
        'cost',
        'balanceQuantity',
    ];

    public function inventory()
    {
        return $this->belongsTo(OhMiPiMedicineInventory::class, 'inventoryId', 'id');
    }
}
