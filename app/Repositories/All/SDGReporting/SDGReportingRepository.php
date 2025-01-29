<?php
namespace App\Repositories\All\SDGReporting;

use App\Models\S_A_SDGReporting;
use App\Repositories\Base\BaseRepository;

class SDGReportingRepository extends BaseRepository implements SDGReportingInterface
{
    /**
     * @var S_A_SDGReporting
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param S_A_SDGReporting $model
     */
    public function __construct(S_A_SDGReporting $model)
    {
        $this->model = $model;
    }



}
