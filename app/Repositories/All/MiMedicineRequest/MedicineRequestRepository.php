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
    public function getByAssigneeId($assigneeId)
    {
        return $this->model->where('assigneeId', $assigneeId)->get();
    }

}
