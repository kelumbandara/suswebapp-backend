<?php
namespace App\Repositories\All\SaSrImpactDetails;

use App\Models\SaSSrImpactDetails;
use App\Repositories\Base\BaseRepository;

class ImpactDetailsRepository extends BaseRepository implements ImpactDetailsInterface
{
    /**
     * @var SaSSrImpactDetails
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaSSrImpactDetails $model
     */
    public function __construct(SaSSrImpactDetails $model)
    {
        $this->model = $model;
    }

    public function findBySdgId($sdgId)
    {
        return $this->model->where('sdgId', $sdgId)->get();
    }

    public function deleteBySdgId($sdgId)
    {
        return $this->model->where('sdgId', $sdgId)->delete();
    }

}
