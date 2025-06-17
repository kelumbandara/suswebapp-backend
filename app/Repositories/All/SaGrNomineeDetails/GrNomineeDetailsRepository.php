<?php
namespace App\Repositories\All\SaGrNomineeDetails;

use App\Models\SaGrNomineeDetails;
use App\Repositories\Base\BaseRepository;

class GrNomineeDetailsRepository extends BaseRepository implements GrNomineeDetailsInterface
{
    /**
     * @var SaGrNomineeDetails
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaGrNomineeDetails $model
     */
    public function __construct(SaGrNomineeDetails $model)
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
