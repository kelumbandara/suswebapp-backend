<?php
namespace App\Repositories\All\HsOhMrBenefitEntitlement;

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
    public function deleteByBenefitId($benefitId)
    {
        return $this->model->where('benefitId', $benefitId)->delete();
    }

    public function findByBenefitId($benefitId)
{
    return $this->model->where('benefitId', $benefitId)->get();
}



}
