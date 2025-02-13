<?php

namespace App\Repositories\All\HsOhMrBenefitEntitlement;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface BenefitEntitlementInterface extends EloquentRepositoryInterface {
    public function findByBenefitId(int $benefitId);
    public function deleteByBenefitId(int $benefitId);
}
