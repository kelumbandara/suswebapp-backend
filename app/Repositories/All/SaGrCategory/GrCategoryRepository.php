<?php
namespace App\Repositories\All\SaGrCategory;

use App\Models\SaGrCategory;
use App\Repositories\Base\BaseRepository;

class GrCategoryRepository extends BaseRepository implements GrCategoryInterface
{
    /**
     * @var SaGrCategory
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaGrCategory $model
     */
    public function __construct(SaGrCategory $model)
    {
        $this->model = $model;
    }


}
