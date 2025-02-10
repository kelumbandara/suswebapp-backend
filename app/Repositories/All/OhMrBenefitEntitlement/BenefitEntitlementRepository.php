<?php
namespace App\Repositories\All\OhMrBenefitEntitlement;

use App\Models\HsOhMrBenefitEntitlement;
use App\Repositories\Base\BaseRepository;

class BenefitEntitlementRepository extends BaseRepository implements BenefitEntitlementInterface
{
    /**
     * @var HsOhMrBenefitEntitlement
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsOhMrBenefitEntitlement $model
     */
    public function __construct(HsOhMrBenefitEntitlement $model)
    {
        $this->model = $model;
    }

    public function deleteByBenefitRequestId($benefitRequestId)
    {
        return $this->model->where('benefitRequestId', $benefitRequestId)->delete();
    }

    public function findByBenefitRequestId($benefitRequestId)
    {
        return $this->model->where('benefitRequestId', $benefitRequestId)->get();
    }

}
