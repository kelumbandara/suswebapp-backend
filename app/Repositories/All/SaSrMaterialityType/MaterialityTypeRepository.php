<?php
namespace App\Repositories\All\SaSrMaterialityType;

use App\Models\SaSSrMaterialityType;
use App\Repositories\Base\BaseRepository;

class MaterialityTypeRepository extends BaseRepository implements MaterialityTypeInterface
{
    /**
     * @var SaSSrMaterialityType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaSSrMaterialityType $model
     */
    public function __construct(SaSSrMaterialityType $model)
    {
        $this->model = $model;
    }


}
