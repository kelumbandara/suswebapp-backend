<?php

namespace App\Repositories\All\OhMrBenefitDocument;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface BenefitDocumentInterface extends EloquentRepositoryInterface {
    public function findByBenefitRequestId(int $benefitRequestId);
    public function deleteByBenefitRequestId(int $benefitRequestId);
}
