<?php
namespace App\Repositories\All\SaAiIaSupplierType;

use App\Models\SaAiIaSupplierType;
use App\Repositories\Base\BaseRepository;

class SupplierTypeRepository extends BaseRepository implements SupplierTypeInterface
{
    /**
     * @var SaAiIaSupplierType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiIaSupplierType $model
     */
    public function __construct(SaAiIaSupplierType $model)
    {
        $this->model = $model;
    }


}
