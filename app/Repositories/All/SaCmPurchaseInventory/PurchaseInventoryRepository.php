<?php
namespace App\Repositories\All\SaCmPurchaseInventory;

use App\Models\SaCmPurchaseInventoryRecord;
use App\Repositories\Base\BaseRepository;

class PurchaseInventoryRepository extends BaseRepository implements PurchaseInventoryInterface
{
    /**
     * @var SaCmPurchaseInventoryRecord
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaCmPurchaseInventoryRecord $model
     */
    public function __construct(SaCmPurchaseInventoryRecord $model)
    {
        $this->model = $model;
    }
    public function filterByStatus(string $status)
    {
        return $this->model->where('status', $status)->get();
    }
    public function getByReviewerId($reviewerId)
    {
        return $this->model->where('reviewerId', $reviewerId)->get();
    }

}
