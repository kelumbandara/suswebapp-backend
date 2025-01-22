<?php
namespace App\Repositories\All\FactoryDeatail;

use App\Models\FactoryDeatail;
use App\Repositories\Base\BaseRepository;

class FactoryDeatailRepository extends BaseRepository implements FactoryDeatailInterface
{
    /**
     * @var  FactoryDeatail
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param FactoryDeatail $model
     */
    public function __construct(FactoryDeatail $model)
    {
        $this->model = $model;
    }



}
