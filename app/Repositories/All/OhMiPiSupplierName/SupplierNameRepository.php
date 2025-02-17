<?php
namespace App\Repositories\All\OhMiPiSupplierName;

use App\Models\HsOhMiPiSupplierName;
use App\Repositories\Base\BaseRepository;

class SupplierNameRepository extends BaseRepository implements SupplierNameInterface
{
    /**
     * @var HsOhMiPiSupplierName
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsOhMiPiSupplierName $model
     */
    public function __construct(HsOhMiPiSupplierName $model)
    {
        $this->model = $model;
    }


}
