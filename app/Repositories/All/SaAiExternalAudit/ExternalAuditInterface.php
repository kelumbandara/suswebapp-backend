<?php

namespace App\Repositories\All\SaAiExternalAudit;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface ExternalAuditInterface extends EloquentRepositoryInterface {
    public function getByApproverId(int $approverId);
    public function filterByYearMonthDivision(int $year, int $month, int $division);
    public function filterByYear($year);
    public function filterByYearAndMonth($year, $month);
}
