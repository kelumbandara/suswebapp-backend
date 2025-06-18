<?php
namespace App\Repositories\All\SaRrEmployeeType;

use App\Models\SaRrEmployeeType;
use App\Repositories\Base\BaseRepository;

class RrEmployeeTypeRepository extends BaseRepository implements RrEmployeeTypeInterface
{
    /**
     * @var SaRrEmployeeType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaRrEmployeeType $model
     */
    public function __construct(SaRrEmployeeType $model)
    {
        $this->model = $model;
    }


}
