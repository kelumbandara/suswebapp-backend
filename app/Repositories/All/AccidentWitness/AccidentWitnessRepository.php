<?php
namespace App\Repositories\All\AccidentWitness;

use App\Models\HsAiAccidentWitness;
use App\Repositories\Base\BaseRepository;

class  AccidentWitnessRepository extends BaseRepository implements AccidentWitnessInterface
{
    /**
     * @var HsAiAccidentWitness
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsAiAccidentWitness $model
     */
    public function __construct(HsAiAccidentWitness $model)
    {
        $this->model = $model;
    }



}
