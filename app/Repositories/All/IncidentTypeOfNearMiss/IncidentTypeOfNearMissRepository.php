<?php
namespace App\Repositories\All\IncidentTypeOfNearMiss;

use App\Models\HsAiIncidentTypeOfNearMiss;
use App\Repositories\Base\BaseRepository;

class IncidentTypeOfNearMissRepository extends BaseRepository implements IncidentTypeOfNearMissInterface
{
    /**
     * @var HsAiIncidentTypeOfNearMiss
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsAiIncidentTypeOfNearMiss $model
     */
    public function __construct(HsAiIncidentTypeOfNearMiss $model)
    {
        $this->model = $model;
    }



}
