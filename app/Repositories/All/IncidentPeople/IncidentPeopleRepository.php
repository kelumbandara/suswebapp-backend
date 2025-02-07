<?php
namespace App\Repositories\All\IncidentPeople;

use App\Models\HsAiIncidentPeople;
use App\Repositories\Base\BaseRepository;

class IncidentPeopleRepository extends BaseRepository implements IncidentPeopleInterface
{
    /**
     * @var HsAiIncidentPeople
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsAiIncidentPeople $model
     */
    public function __construct(HsAiIncidentPeople $model)
    {
        $this->model = $model;
    }
    public function deleteByIncidentId($incidentId)
    {
        return $this->model->where('incidentId', $incidentId)->delete();
    }

    public function findByIncidentId($incidentId)
{
    return $this->model->where('incidentId', $incidentId)->get();
}



}
