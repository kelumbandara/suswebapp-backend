<?php

namespace App\Repositories\All\OhMrBenefitEntitlement;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface BenefitEntitlementInterface extends EloquentRepositoryInterface {
    public function findByEntitlementId(int $entitlementId);
    public function deleteByEntitlementId(int $entitlementId);
}
