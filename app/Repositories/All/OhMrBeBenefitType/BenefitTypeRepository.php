<?php
namespace App\Repositories\All\OhMrBeBenefitType;

use App\Models\HsOhMrBeBenefitType;
use App\Repositories\Base\BaseRepository;

class BenefitTypeRepository extends BaseRepository implements BenefitTypeInterface
{
    /**
     * @var HsOhMrBeBenefitType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsOhMrBeBenefitType $model
     */
    public function __construct(HsOhMrBeBenefitType $model)
    {
        $this->model = $model;
    }


}
