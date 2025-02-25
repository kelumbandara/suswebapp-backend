<?php
namespace App\Repositories\All\IncidentRecord;

use App\Models\HsAiIncidentRecode;
use App\Repositories\Base\BaseRepository;

class IncidentRecodeRepository extends BaseRepository implements IncidentRecodeInterface
{
    /**
     * @var HsAiIncidentRecode
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsAiIncidentRecode $model
     */
    public function __construct(HsAiIncidentRecode $model)
    {
        $this->model = $model;
    }

    public function getByAssigneeId($assigneeId)
    {
        return $this->model->where('assigneeId', $assigneeId)->get();
    }

}
