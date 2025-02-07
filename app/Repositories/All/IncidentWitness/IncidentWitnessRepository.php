<?php
namespace App\Repositories\All\IncidentWitness;

use App\Models\HsAiIncidentWitness;
use App\Repositories\Base\BaseRepository;

class IncidentWitnessRepository extends BaseRepository implements IncidentWitnessInterface
{
    /**
     * @var HsAiIncidentRecode
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsAiIncidentWitness $model
     */
    public function __construct(HsAiIncidentWitness $model)
    {
        $this->model = $model;
    }



}
