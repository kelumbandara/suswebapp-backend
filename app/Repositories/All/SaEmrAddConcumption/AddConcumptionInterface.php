<?php

namespace App\Repositories\All\SaEmrAddConcumption;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface AddConcumptionInterface extends EloquentRepositoryInterface {
    public function findByEnvirementId(int $envirementId);
    public function deleteByEnvirementId(int $envirementId);
}
