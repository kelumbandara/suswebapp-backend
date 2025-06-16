<?php

namespace App\Repositories\All\SaGrNomineeDetails;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface GrNomineeDetailsInterface extends EloquentRepositoryInterface {
    public function findByNomineeId(int $grievanceId);
    public function deleteByNomineeId(int $grievanceId);
}
