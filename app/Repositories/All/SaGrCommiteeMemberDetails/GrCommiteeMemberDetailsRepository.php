<?php
namespace App\Repositories\All\SaGrCommiteeMemberDetails;

use App\Models\SaGrCommitteeMemberDetails;
use App\Repositories\Base\BaseRepository;

class GrCommiteeMemberDetailsRepository extends BaseRepository implements GrCommiteeMemberDetailsInterface
{
    /**
     * @var SaGrCommitteeMemberDetails
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaGrCommitteeMemberDetails $model
     */
    public function __construct(SaGrCommitteeMemberDetails $model)
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
