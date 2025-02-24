<?php
namespace App\Repositories\All\HazardAndRisk;

use App\Models\HsHrDivision;
use App\Models\HsHrHazardRisk;
use App\Repositories\Base\BaseRepository;

class HazardAndRiskRepository extends BaseRepository implements HazardAndRiskInterface
{
    /**
     * @var HsHrHazardRisk
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsHrHazardRisk $model
     */
    public function __construct(HsHrHazardRisk $model)
    {
        $this->model = $model;
    }

    public function countAll()
{
    return HsHrHazardRisk::count();
}

public function countByStatus($status)
{
    return HsHrHazardRisk::where('status', $status)->count();
}

public function sumField($field)
{
    return HsHrHazardRisk::sum($field);
}

public function countByDivision($division)
{
    return HsHrHazardRisk::where('division', $division)->count();
}

public function getAllDivisions()
{
    return HsHrHazardRisk::select('division')->distinct()->get();
}
public function getDistinctDivisions()
{
    return $this->model->select('division')->distinct()->get();
}
public function getByAssigneeId($assigneeId)
{
    return $this->model->where('assigneeId', $assigneeId)->get();
}




}
