<?php
namespace App\Repositories\All\SaAiIaActionPlan;

use App\Models\SaAiIaActionPlan;
use App\Repositories\Base\BaseRepository;

class ActionPlanRepository extends BaseRepository implements ActionPlanInterface
{
    /**
     * @var SaAiIaActionPlan
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiIaActionPlan $model
     */
    public function __construct(SaAiIaActionPlan $model)
    {
        $this->model = $model;
    }
    public function findByInternalAuditId($internalAuditId)
    {
        return $this->model->where('internalAuditId', $internalAuditId)->get();
    }

    public function deleteByInternalAuditId($internalAuditId)
    {
        return $this->model->where('internalAuditId', $internalAuditId)->delete();
    }

}
