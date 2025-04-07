<?php

namespace App\Repositories\All\SaAiInternalAuditRecode;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface InternalAuditRecodeInterface extends EloquentRepositoryInterface {
    public function getByApproverId(int $approverId);

}
