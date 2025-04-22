<?php

namespace App\Repositories\All\SaETargetSetting;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface TargetSettingRecodeInterface extends EloquentRepositoryInterface {
    public function getByAssigneeId(int $assigneeId);
}
