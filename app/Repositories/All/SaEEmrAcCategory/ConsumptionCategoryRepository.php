<?php
namespace App\Repositories\All\SaEEmrAcCategory;

use App\Models\SaEEmrAcCategory;
use App\Repositories\Base\BaseRepository;

class ConsumptionCategoryRepository extends BaseRepository implements ConsumptionCategoryInterface
{
    /**
     * @var SaEEmrAcCategory
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaEEmrAcCategory $model
     */
    public function __construct( SaEEmrAcCategory $model)
    {
        $this->model = $model;
    }


}
