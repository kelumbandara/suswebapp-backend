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
    public function findByIncidentId($incidentId)
    {
        return $this->model->where('incidentId', $incidentId)->get();
    }

    public function deleteByIncidentId($incidentId)
    {
        return $this->model->where('incidentId', $incidentId)->delete();
    }




}
