<?php
namespace App\Repositories\All\SaRagRecode;

use App\Models\SaRagRecord;
use App\Repositories\Base\BaseRepository;

class RagRecodeRepository extends BaseRepository implements RagRecodeInterface
{
    /**
     * @var SaRagRecord
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaRagRecord $model
     */
    public function __construct(SaRagRecord $model)
    {
        $this->model = $model;
    }
    public function filterByParams($startDate = null, $endDate = null)
    {
        $query = $this->model->newQuery();

        if ($startDate && $endDate) {
            $query->whereBetween('updated_at', [$startDate, $endDate]);
        }

        return $query->get();
    }

    public function filterByYear($year)
    {
        return $this->model->whereYear('updated_at', $year)->get();
    }

}
