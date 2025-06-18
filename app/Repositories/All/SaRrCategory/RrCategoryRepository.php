<?php
namespace App\Repositories\All\SaRrCategory;

use App\Models\SaRrCategory;
use App\Repositories\Base\BaseRepository;

class RrCategoryRepository extends BaseRepository implements RrCategoryInterface
{
    /**
     * @var SaRrCategory
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaRrCategory $model
     */
    public function __construct(SaRrCategory $model)
    {
        $this->model = $model;
    }


}
