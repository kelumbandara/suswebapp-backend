<?php

namespace App\Repositories\All\SaGrNomineeDetails;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface GrNomineeDetailsInterface extends EloquentRepositoryInterface {
    public function findByGrievanceId(int $grievanceId);
    public function deleteByGrievanceId(int $grievanceId);
}
