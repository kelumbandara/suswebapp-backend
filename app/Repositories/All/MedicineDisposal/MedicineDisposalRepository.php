<?php
namespace App\Repositories\All\MedicineDisposal;

use App\Models\OhMiPiMiDisposal;
use App\Repositories\Base\BaseRepository;

class MedicineDisposalRepository extends BaseRepository implements MedicineDisposalInterface
{
    /**
     * @var OhMiPiMiDisposal
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param OhMiPiMiDisposal $model
     */
    public function __construct(OhMiPiMiDisposal $model)
    {
        $this->model = $model;
    }
    public function findByInventoryId($inventoryId)
    {
        return $this->model->where('inventoryId', $inventoryId)->get();
    }

    public function deleteByInventoryId($inventoryId)
    {
        return $this->model->where('inventoryId', $inventoryId)->delete();
    }




}
