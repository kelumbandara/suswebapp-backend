<?php
namespace App\Repositories\All\SaETsCategory;

use App\Models\SaETsCategory;
use App\Repositories\Base\BaseRepository;

class TsCategoryRepository extends BaseRepository implements TsCategoryInterface
{
    /**
     * @var SaETsCategory
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaETsCategory $model
     */
    public function __construct(SaETsCategory $model)
    {
        $this->model = $model;
    }


}
