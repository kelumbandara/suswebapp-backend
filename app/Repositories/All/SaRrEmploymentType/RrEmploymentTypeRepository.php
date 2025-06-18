<?php
namespace App\Repositories\All\SaRrEmploymentType;

use App\Models\SaRrEmploymentType;
use App\Repositories\Base\BaseRepository;

class RrEmploymentTypeRepository extends BaseRepository implements RrEmploymentTypeInterface
{
    /**
     * @var SaRrEmploymentType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaRrEmploymentType $model
     */
    public function __construct(SaRrEmploymentType $model)
    {
        $this->model = $model;
    }


}
