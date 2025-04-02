<?php
namespace App\Repositories\All\SaSrImpactType;

use App\Models\SaSSrIdImpactType;
use App\Models\SaSSrImpactDetails;
use App\Repositories\Base\BaseRepository;

class ImpactTypeRepository extends BaseRepository implements ImpactTypeInterface
{
    /**
     * @var SaSSrIdImpactType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaSSrIdImpactType $model
     */
    public function __construct(SaSSrIdImpactType $model)
    {
        $this->model = $model;
    }


}
