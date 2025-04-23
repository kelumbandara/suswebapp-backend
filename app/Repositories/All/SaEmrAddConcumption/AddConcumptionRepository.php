<?php
namespace App\Repositories\All\SaEmrAddConcumption;

use App\Models\SaEEmrAddConsumption;
use App\Repositories\Base\BaseRepository;

class AddConcumptionRepository extends BaseRepository implements AddConcumptionInterface
{
    /**
     * @var SaEEmrAddConsumption
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaEEmrAddConsumption $model
     */
    public function __construct(SaEEmrAddConsumption $model)
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
