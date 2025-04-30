<?php

namespace App\Repositories\All\SaEnvirementManagementRecode;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface EnvirementManagementRecodeInterface extends EloquentRepositoryInterface {
    public function getByApproverId(int $approverId);
    public function getByReviewerId(int $reviewerId);
    public function filterByYearMonthDivision(int $year, int $month, int $division);
    public function filterByYear($year);
    public function filterByYearAndMonth($year, $month);

}
