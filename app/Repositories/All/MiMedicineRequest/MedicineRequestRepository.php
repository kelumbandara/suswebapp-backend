<?php
namespace App\Repositories\All\MiMedicineRequest;

use App\Models\HsOhMiMedicineRequest;
use App\Repositories\Base\BaseRepository;

class MedicineRequestRepository extends BaseRepository implements MedicineRequestInterface
{
    /**
     * @var HsOhMiMedicineRequest
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsOhMiMedicineRequest $model
     */
    public function __construct(HsOhMiMedicineRequest $model)
    {
        $this->model = $model;
    }
    public function getByAssigneeId($approverId)
    {
        return $this->model->where('approverId', $approverId)->get();
    }

}
