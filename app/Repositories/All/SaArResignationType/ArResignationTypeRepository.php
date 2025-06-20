<?php
namespace App\Repositories\All\SaArResignationType;

use App\Models\SaArResignationType;
use App\Repositories\Base\BaseRepository;

class ArResignationTypeRepository extends BaseRepository implements ArResignationTypeInterface
{
    /**
     * @var SaArResignationType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaArResignationType $model
     */
    public function __construct(SaArResignationType $model)
    {
        $this->model = $model;
    }


}
