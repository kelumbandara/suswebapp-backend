<?php
namespace App\Repositories\All\OhMiPiSupplierType;

use App\Models\HsOhMiPiSupplierType;
use App\Repositories\Base\BaseRepository;

class SupplierTypeRepository extends BaseRepository implements SupplierTypeInterface
{
    /**
     * @var HsOhMiPiSupplierType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsOhMiPiSupplierType $model
     */
    public function __construct(HsOhMiPiSupplierType $model)
    {
        $this->model = $model;
    }


}
