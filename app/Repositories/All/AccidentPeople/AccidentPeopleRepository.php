<?php
namespace App\Repositories\All\AccidentPeople;

use App\Models\HsAiAccidentPeople;
use App\Repositories\Base\BaseRepository;

class    AccidentPeopleRepository extends BaseRepository implements AccidentPeopleInterface
{
    /**
     * @var HsAiAccidentPeople
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsAiAccidentPeople $model
     */
    public function __construct(HsAiAccidentPeople $model)
    {
        $this->model = $model;
    }



}
