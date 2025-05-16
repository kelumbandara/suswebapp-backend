<?php

namespace App\Repositories\All\SaCmPurchaseInventory;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface PurchaseInventoryInterface extends EloquentRepositoryInterface {
    public function filterByStatus(string $status);
    public function getByReviewerId($reviewerId);



}
