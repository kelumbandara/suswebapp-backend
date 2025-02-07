<?php
namespace App\Repositories\All\IncidentFactors;

use App\Models\HsAiIncidentFactors;
use App\Repositories\Base\BaseRepository;

class IncidentFactorsRepository extends BaseRepository implements IncidentFactorsInterface
{
    /**
     * @var HsAiIncidentFactors
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsAiIncidentFactors $model
     */
    public function __construct(HsAiIncidentFactors $model)
    {
        $this->model = $model;
    }



}
