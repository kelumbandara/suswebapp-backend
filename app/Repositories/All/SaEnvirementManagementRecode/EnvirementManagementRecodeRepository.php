<?php
namespace App\Repositories\All\SaEnvirementManagementRecode;

use App\Models\SaEEnvirementManagementRecode;
use App\Repositories\Base\BaseRepository;

class EnvirementManagementRecodeRepository extends BaseRepository implements EnvirementManagementRecodeInterface
{
    /**
     * @var SaEEnvirementManagementRecode
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaEEnvirementManagementRecode $model
     */
    public function __construct(SaEEnvirementManagementRecode $model)
    {
        $this->model = $model;
    }
    public function getByApproverId($approverId)
    {
        return $this->model->where('approverId', $approverId)->get();
    }
    public function getByReviewerId($reviewerId)
    {
        return $this->model->where('reviewerId', $reviewerId)->get();
    }
    public function filterByYearMonthDivision($year, $month, $division)
    {
        return $this->model
            ->where('year', $year)
            ->where('month', $month)
            ->where('division', $division)
            ->get();
    }

}
