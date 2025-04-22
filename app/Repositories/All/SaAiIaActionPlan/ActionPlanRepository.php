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
    public function findByIntarnalAuditId($intarnalAuditId)
    {
        return $this->model->where('intarnalAuditId', $intarnalAuditId)->get();
    }

    public function deleteByIntarnalAuditId($intarnalAuditId)
    {
        return $this->model->where('intarnalAuditId', $intarnalAuditId)->delete();
    }

}
