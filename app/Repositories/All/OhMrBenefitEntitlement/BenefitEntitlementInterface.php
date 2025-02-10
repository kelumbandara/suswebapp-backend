<?php

namespace App\Repositories\All\OhMrBenefitEntitlement;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface BenefitEntitlementInterface extends EloquentRepositoryInterface {
    public function findByBenefitRequestId(int $benefitRequestId);
    public function deleteByBenefitRequestId(int $benefitRequestId);
}
