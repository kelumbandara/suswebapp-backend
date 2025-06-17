<?php
namespace App\Repositories\All\SaGrievanceRecord;

use App\Models\SaGrievanceRecord;
use App\Repositories\Base\BaseRepository;

class GrievanceRepository extends BaseRepository implements GrievanceInterface
{
    /**
     * @var SaGrievanceRecord
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaGrievanceRecord $model
     */
    public function __construct(SaGrievanceRecord $model)
    {
        $this->model = $model;
    }

    public function getByAssigneeId($supervisorId)
    {
        return $this->model->where('supervisorId', $supervisorId)->get();
    }

}
