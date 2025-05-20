<?php

namespace App\Repositories\All\SaAiEaActionPlan;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface EaActionPlanInterface extends EloquentRepositoryInterface {
    public function findByExternalAuditId(int $externalAuditId);
    public function deleteByExternalAuditId(int $externalAuditId);
}
