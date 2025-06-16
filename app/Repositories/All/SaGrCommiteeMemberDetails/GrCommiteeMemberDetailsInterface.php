<?php

namespace App\Repositories\All\SaGrCommiteeMemberDetails;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface GrCommiteeMemberDetailsInterface extends EloquentRepositoryInterface {
    public function findByCommitteeMemberId(int $grievanceId);
    public function deleteByCommitteeMemberId(int $grievanceId);
}
