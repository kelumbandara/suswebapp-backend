<?php
namespace App\Repositories\All\SaSrPillars;

use App\Models\SaSSrPillars;
use App\Repositories\Base\BaseRepository;

class PillarsRepository extends BaseRepository implements PillarsInterface
{
    /**
     * @var SaSSrPillars
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaSSrPillars $model
     */
    public function __construct(SaSSrPillars $model)
    {
        $this->model = $model;
    }


}
