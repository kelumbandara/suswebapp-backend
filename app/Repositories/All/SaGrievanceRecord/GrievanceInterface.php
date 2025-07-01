<?php
namespace App\Repositories\All\SaGrievanceRecord;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface GrievanceInterface extends EloquentRepositoryInterface
{
    public function getByAssigneeId(int $assigneeId);
    public function filterByParams($startDate, $endDate, $category, $businessUnit);
    public function filterByYear($year);
    public function filterByYearAndMonth($startDate, $endDate, $businessUni);
}
