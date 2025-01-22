<?php
namespace App\Repositories\All\FactoryPerson;

use App\Models\FactoryDeatail;
use App\Models\FactoryPerson;
use App\Repositories\Base\BaseRepository;

class FactoryPersonRepository extends BaseRepository implements FactoryPersonInterface
{
    /**
     * @var  FactoryPerson
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param FactoryPerson $model
     */
    public function __construct(FactoryPerson $model)
    {
        $this->model = $model;
    }



}
