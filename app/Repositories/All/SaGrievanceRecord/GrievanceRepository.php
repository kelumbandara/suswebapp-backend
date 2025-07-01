<?php
namespace App\Repositories\All\SaGrievanceRecord;

use App\Models\SaGrievanceRecord;
use App\Repositories\Base\BaseRepository;

class GrievanceRepository extends BaseRepository implements GrievanceInterface
{
    /**
     * @var SaGrievanceRecord
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaGrievanceRecord $model
     */
    public function __construct(SaGrievanceRecord $model)
    {
        $this->model = $model;
    }

    public function getByAssigneeId($assigneeId)
    {
        return $this->model->where('assigneeId', $assigneeId)->get();
    }
    public function filterByParams($startDate, $endDate, $category, $businessUnit)
    {
        $query = $this->model->newQuery();

        if ($startDate && $endDate) {
            $query->whereBetween('updated_at', [$startDate, $endDate]);
        }

        if ($businessUnit) {
            $query->where('businessUnit', $businessUnit);
        }
        if ($category) {
            $query->where('category', $category);
        }

        return $query->get();

    }

    public function filterByYear($year)
    {
        return $this->model->where('updated_at', $year)->get();
    }

    public function filterByYearAndMonth($startDate, $endDate, $businessUnit)
    {$query = $this->model->newQuery();

        if ($startDate && $endDate) {
            $query->whereBetween('updated_at', [$startDate, $endDate]);
        }

        if ($businessUnit) {
            $query->where('businessUnit', $businessUnit);
        }


        return $query->get();
    }

}
