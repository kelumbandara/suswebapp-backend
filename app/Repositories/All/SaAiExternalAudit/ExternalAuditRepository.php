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
            ->where('year', $year)
            ->where('month', $month)
            ->where('division', $division)
            ->get();
    }
    public function filterByYear($year)
    {
        return $this->model->where('year', $year)->get();
    }
    public function filterByYearAndMonth($year, $month)
    {
        return $this->model
            ->where('year', $year)
            ->where('month', $month)
            ->get();
    }

}
