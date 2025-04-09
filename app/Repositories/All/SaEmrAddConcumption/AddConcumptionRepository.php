<?php
namespace App\Repositories\All\SaEmrAddConcumption;

use App\Models\SaEEmrAddConcumption;
use App\Repositories\Base\BaseRepository;

class AddConcumptionRepository extends BaseRepository implements AddConcumptionInterface
{
    /**
     * @var SaEEmrAddConcumption
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaEEmrAddConcumption $model
     */
    public function __construct(SaEEmrAddConcumption $model)
    {
        $this->model = $model;
    }

    public function findByEnvirementId($envirementId)
    {
        return $this->model->where('envirementId', $envirementId)->get();
    }

    public function deleteByEnvirementId($envirementId)
    {
        return $this->model->where('envirementId', $envirementId)->delete();
    }


}
