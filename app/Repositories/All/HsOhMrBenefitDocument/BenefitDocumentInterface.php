<?php

namespace App\Repositories\All\HsOhMrBenefitDocument;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface BenefitDocumentInterface extends EloquentRepositoryInterface {
    public function findByBenefitId(int $benefitId);
    public function deleteByBenefitId(int $benefitId);
}
