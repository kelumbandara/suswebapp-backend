<?php
namespace App\Repositories\All\SaAiExternalAudit;

use App\Models\SaAiExternalAuditRecode;
use App\Repositories\Base\BaseRepository;

class ExternalAuditRepository extends BaseRepository implements ExternalAuditInterface
{
    /**
     * @var SaAiExternalAuditRecode
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiExternalAuditRecode $model
     */
    public function __construct(SaAiExternalAuditRecode $model)
    {
        $this->model = $model;
    }

    public function getByAssigneeId($assigneeId)
    {
        return $this->model->where('assigneeId', $assigneeId)->get();
    }

}
