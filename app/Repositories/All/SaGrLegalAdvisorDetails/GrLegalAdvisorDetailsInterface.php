<?php

namespace App\Repositories\All\SaGrLegalAdvisorDetails;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface GrLegalAdvisorDetailsInterface extends EloquentRepositoryInterface {
    public function findByLegalAdvisorId(int $grievanceId);
    public function deleteByLegalAdvisorId(int $grievanceId);
}
