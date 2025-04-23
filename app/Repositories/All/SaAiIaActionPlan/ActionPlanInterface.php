<?php

namespace App\Repositories\All\SaAiIaActionPlan;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface ActionPlanInterface extends EloquentRepositoryInterface {
    public function findByInternalAuditId(int $internalAuditId);
    public function deleteByInternalAuditId(int $internalAuditId);
}
