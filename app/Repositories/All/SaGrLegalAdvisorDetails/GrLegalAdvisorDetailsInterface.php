<?php

namespace App\Repositories\All\SaGrLegalAdvisorDetails;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface GrLegalAdvisorDetailsInterface extends EloquentRepositoryInterface {
    public function findByGrievanceId(int $grievanceId);
    public function deleteByGrievanceId(int $grievanceId);
}
