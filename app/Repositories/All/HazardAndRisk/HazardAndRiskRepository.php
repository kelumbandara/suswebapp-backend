<?php
namespace App\Repositories\All\HazardAndRisk;

use App\Models\HsHrHazardRisk;
use App\Repositories\Base\BaseRepository;

class HazardAndRiskRepository extends BaseRepository implements HazardAndRiskInterface
{
    /**
     * @var HsHrHazardRisk
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsHrHazardRisk $model
     */
    public function __construct(HsHrHazardRisk $model)
    {
        $this->model = $model;
    }



}
