<?php
namespace App\Repositories\All\SaGrLegalAdvisorDetails;

use App\Models\SaGrLegalAdvisorDetails;
use App\Repositories\Base\BaseRepository;

class GrLegalAdvisorDetailsRepository extends BaseRepository implements GrLegalAdvisorDetailsInterface
{
    /**
     * @var SaGrLegalAdvisorDetails
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaGrLegalAdvisorDetails $model
     */
    public function __construct(SaGrLegalAdvisorDetails $model)
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
