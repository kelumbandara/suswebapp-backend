<?php
namespace App\Repositories\All\SaAiEaActionPlan;

use App\Models\SaAiEaActionPlan;
use App\Repositories\Base\BaseRepository;

class EaActionPlanRepository extends BaseRepository implements EaActionPlanInterface
{
    /**
     * @var SaAiEaActionPlan
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiEaActionPlan $model
     */
    public function __construct(SaAiEaActionPlan $model)
    {
        $this->model = $model;
    }
    public function findByExternalAuditId($externalAuditId)
    {
        return $this->model->where('externalAuditId', $externalAuditId)->get();
    }

    public function deleteByExternalAuditId($externalAuditId)
    {
        return $this->model->where('externalAuditId', $externalAuditId)->delete();
    }
    public function getByExternalAuditId($externalAuditId)
    {
        return $this->model->where('externalAuditId', $externalAuditId)->first();
    }


}
