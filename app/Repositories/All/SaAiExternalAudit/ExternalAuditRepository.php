<?php
namespace App\Repositories\All\SaAiExternalAudit;

use App\Models\SaAiExternalAuditRecode;
use App\Repositories\Base\BaseRepository;

class ExternalAuditRepository extends BaseRepository implements ExternalAuditInterface
{
    /**
     * @var SaAiExternalAuditRecode
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiExternalAuditRecode $model
     */
    public function __construct(SaAiExternalAuditRecode $model)
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
    public function getBetweenDates($startDate, $endDate)
    {
        return $this->model->whereBetween('auditDate', [$startDate, $endDate])->get();
    }

}
