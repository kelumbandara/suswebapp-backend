<?php
namespace App\Repositories\All\IncidentTypeOfConcern;

use App\Models\HsAiIncidentTypeOfConcern;
use App\Repositories\Base\BaseRepository;

class IncidentTypeOfConcernRepository extends BaseRepository implements IncidentTypeOfConcernInterface
{
    /**
     * @var HsAiIncidentTypeOfConcern
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsAiIncidentTypeOfConcern $model
     */
    public function __construct(HsAiIncidentTypeOfConcern $model)
    {
        $this->model = $model;
    }



}
