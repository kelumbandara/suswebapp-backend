<?php

namespace App\Repositories\All\SaETargetSetting;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface TargetSettingRecodeInterface extends EloquentRepositoryInterface {
    public function getByApproverId(int $approverId);
    public function filterByYearMonthDivision(int $year, int $month, int $division);

}
