<?php
namespace App\Repositories\All\SaSDGRecode;

use App\Models\SaSSdgReportingRecode;
use App\Repositories\Base\BaseRepository;

class SDGRecodeRepository extends BaseRepository implements SDGRecodeInterface
{
    /**
     * @var SaSSdgReportingRecode
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaSSdgReportingRecode $model
     */
    public function __construct(SaSSdgReportingRecode $model)
    {
        $this->model = $model;
    }
    public function getByAssigneeId($assigneeId)
    {
        return $this->model->where('assigneeId', $assigneeId)->get();
    }

}
