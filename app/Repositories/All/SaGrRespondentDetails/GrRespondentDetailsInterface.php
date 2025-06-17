<?php

namespace App\Repositories\All\SaGrRespondentDetails;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface GrRespondentDetailsInterface extends EloquentRepositoryInterface {
    public function findByGrievanceId(int $grievanceId);
    public function deleteByGrievanceId(int $grievanceId);
}
