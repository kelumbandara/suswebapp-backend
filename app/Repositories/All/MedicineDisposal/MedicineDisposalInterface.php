<?php

namespace App\Repositories\All\MedicineDisposal;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface MedicineDisposalInterface extends EloquentRepositoryInterface {
    public function findByInventoryId(int $inventoryId);
    public function deleteByInventoryId(int $inventoryId);
}
