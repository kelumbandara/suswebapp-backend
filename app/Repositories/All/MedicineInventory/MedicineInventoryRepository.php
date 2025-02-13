<?php
namespace App\Repositories\All\MedicineInventory;

use App\Models\OhMiPiMedicineInventory;
use App\Repositories\Base\BaseRepository;

class MedicineInventoryRepository extends BaseRepository implements MedicineInventoryInterface
{
    /**
     * @var OhMiPiMedicineInventory
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param OhMiPiMedicineInventory $model
     */
    public function __construct(OhMiPiMedicineInventory $model)
    {
        $this->model = $model;
    }

}
