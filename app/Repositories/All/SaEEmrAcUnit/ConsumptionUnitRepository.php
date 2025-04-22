<?php
namespace App\Repositories\All\SaEEmrAcUnit;

use App\Models\SaEEmrAcUnit;
use App\Repositories\Base\BaseRepository;

class ConsumptionUnitRepository extends BaseRepository implements ConsumptionUnitInterface
{
    /**
     * @var SaEEmrAcUnit
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaEEmrAcUnit $model
     */
    public function __construct(SaEEmrAcUnit $model)
    {
        $this->model = $model;
    }


}
