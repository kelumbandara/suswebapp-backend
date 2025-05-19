<?php
namespace App\Repositories\All\SaAiInternalAuditRecode;

use App\Models\SaAiInternalAuditRecode;
use App\Repositories\Base\BaseRepository;

class InternalAuditRecodeRepository extends BaseRepository implements InternalAuditRecodeInterface
{
    /**
     * @var SaAiInternalAuditRecode
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiInternalAuditRecode $model
     */
    public function __construct(SaAiInternalAuditRecode $model)
    {
        $this->model = $model;
    }
    public function getByApproverId($approverId)
    {
        return $this->model->where('approverId', $approverId)->get();
    }
    public function filterByYearMonthDivision($year, $month, $division)
    {
        return $this->model
            ->whereYear('auditDate', $year)
            ->whereMonth('auditDate', $month)
            ->where('division', $division)
            ->get();
    }

    public function filterByYear($year)
    {
        return $this->model
            ->whereYear('auditDate', $year)
            ->get();
    }

    public function filterByYearAndMonth($year, $month)
    {
        return $this->model
            ->whereYear('auditDate', $year)
            ->whereMonth('auditDate', $month)
            ->get();
    }
    public function filterByParams($startDate = null, $endDate = null, $division = null)
    {
        $query = $this->model->newQuery();

        if ($startDate && $endDate) {
            $query->whereBetween('auditDate', [$startDate, $endDate]);
        }

        if ($division) {
            $query->where('division', $division);
        }

        return $query->get();
    }



}
