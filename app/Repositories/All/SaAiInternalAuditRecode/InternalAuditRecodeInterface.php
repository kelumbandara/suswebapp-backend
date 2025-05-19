<?php
namespace App\Repositories\All\SaAiInternalAuditRecode;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface InternalAuditRecodeInterface extends EloquentRepositoryInterface
{
    public function getByApproverId(int $approverId);
    public function filterByYearMonthDivision(int $year, int $month, int $division);
    public function filterByYear($year);
    public function filterByYearAndMonth($year, $month);
    public function filterByParams($startDate, $endDate,  $division);

}
