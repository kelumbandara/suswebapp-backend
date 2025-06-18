<?php
namespace App\Repositories\All\SaRrFunction;

use App\Models\SaRrFunction;
use App\Repositories\Base\BaseRepository;

class RrFunctionRepository extends BaseRepository implements RrFunctionInterface
{
    /**
     * @var SaRrFunction
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaRrFunction $model
     */
    public function __construct(SaRrFunction $model)
    {
        $this->model = $model;
    }


}
