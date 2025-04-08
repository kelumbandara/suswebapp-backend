<?php

namespace App\Repositories\All\SaAiIaQrGroupRecode;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface GroupRecodeInterface extends EloquentRepositoryInterface {
    public function findByQuectionRecoId(int $quectionRecoId);
    public function deleteByQuectionRecoId(int $quectionRecoId);
}
