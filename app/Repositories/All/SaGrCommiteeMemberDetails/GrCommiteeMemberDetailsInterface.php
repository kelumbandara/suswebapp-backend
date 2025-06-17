<?php

namespace App\Repositories\All\SaGrCommiteeMemberDetails;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface GrCommiteeMemberDetailsInterface extends EloquentRepositoryInterface {
    public function findByGrievanceId(int $grievanceId);
    public function deleteByGrievanceId(int $grievanceId);
}
