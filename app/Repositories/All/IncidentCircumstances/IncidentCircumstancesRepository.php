<?php
namespace App\Repositories\All\IncidentCircumstances;

use App\Models\HsAiIncidentCircumstances;
use App\Repositories\Base\BaseRepository;

class IncidentCircumstancesRepository extends BaseRepository implements IncidentCircumstancesInterface
{
    /**
     * @var HsAiIncidentCircumstances
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsAiIncidentCircumstances $model
     */
    public function __construct(HsAiIncidentCircumstances $model)
    {
        $this->model = $model;
    }



}
