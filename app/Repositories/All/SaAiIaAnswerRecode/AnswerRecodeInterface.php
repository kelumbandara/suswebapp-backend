<?php

namespace App\Repositories\All\SaAiIaAnswerRecode;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface AnswerRecodeInterface extends EloquentRepositoryInterface {
    public function findByInternalAuditId(int $internalAuditId);
    public function deleteByInternalAuditId(int $internalAuditId);
}
