<?php

namespace App\Repositories\All\SaAiIaQrGroupRecode;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface GroupRecodeInterface extends EloquentRepositoryInterface {
    public function findByQuestionRecoId(int $questionRecoId);
    public function deleteByQuestionRecoId(int $questionRecoId);
}
