<?php

namespace App\Repositories\All\SaGrRespondentDetails;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface GrRespondentDetailsInterface extends EloquentRepositoryInterface {
    public function findByRespondentId(int $grievanceId);
    public function deleteByRespondentId(int $grievanceId);
}
