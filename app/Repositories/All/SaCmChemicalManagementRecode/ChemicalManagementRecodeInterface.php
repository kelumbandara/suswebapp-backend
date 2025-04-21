<?php

namespace App\Repositories\All\SaCmChemicalManagementRecode;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface ChemicalManagementRecodeInterface extends EloquentRepositoryInterface {
    public function getByReviewerId(int $reviewerId);
}
