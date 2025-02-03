<?php
namespace App\Repositories\All\AccidentCategory;

use App\Models\HsAiAccidentCategory;
use App\Repositories\Base\BaseRepository;

class AccidentCategoryRepository extends BaseRepository implements AccidentCategoryInterface
{
    /**
     * @var HsAiAccidentCategory
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsAiAccidentCategory $model
     */
    public function __construct(HsAiAccidentCategory $model)
    {
        $this->model = $model;
    }



}
