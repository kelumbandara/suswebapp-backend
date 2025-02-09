<?php
namespace App\Repositories\All\OhMrBenefitRequest;

use App\Models\HsOhMrBenefitRequest;
use App\Repositories\Base\BaseRepository;

class BenefitRequestRepository extends BaseRepository implements BenefitRequestInterface
{
    /**
     * @var HsOhMrBenefitRequest
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsOhMrBenefitRequest $model
     */
    public function __construct(HsOhMrBenefitRequest $model)
    {
        $this->model = $model;
    }


}
