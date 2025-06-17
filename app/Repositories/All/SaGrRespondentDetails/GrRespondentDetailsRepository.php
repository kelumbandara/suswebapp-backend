<?php
namespace App\Repositories\All\SaGrRespondentDetails;

use App\Models\SaGrRespondentDetails;
use App\Repositories\Base\BaseRepository;

class GrRespondentDetailsRepository extends BaseRepository implements GrRespondentDetailsInterface
{
    /**
     * @var SaGrRespondentDetails
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaGrRespondentDetails $model
     */
    public function __construct(SaGrRespondentDetails $model)
    {
        $this->model = $model;
    }
    public function findByGrievanceId($grievanceId)
    {
        return $this->model->where('grievanceId', $grievanceId)->get();
    }

    public function deleteByGrievanceId($grievanceId)
    {
        return $this->model->where('grievanceId', $grievanceId)->delete();
    }

}
