<?php

namespace App\Repositories\All\SaAiIaAnswerRecode;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface AnswerRecodeInterface extends EloquentRepositoryInterface {
    public function findByIntarnalAuditId(int $intarnalAuditId);
    public function deleteByIntarnalAuditId(int $intarnalAuditId);
}
