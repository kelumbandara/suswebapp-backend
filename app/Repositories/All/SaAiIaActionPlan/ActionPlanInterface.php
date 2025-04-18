<?php

namespace App\Repositories\All\SaAiIaActionPlan;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface ActionPlanInterface extends EloquentRepositoryInterface {
    public function findByIntarnalAuditId(int $intarnalAuditId);
    public function deleteByIntarnalAuditId(int $intarnalAuditId);
}
