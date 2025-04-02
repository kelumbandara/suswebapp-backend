<?php

namespace App\Repositories\All\SaSrImpactDetails;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface ImpactDetailsInterface extends EloquentRepositoryInterface {
    public function findBySdgId(int $sdgId);
    public function deleteBySdgId(int $sdgId);
}
