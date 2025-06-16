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
    public function findByCommitteeMemberId($grievanceId)
    {
        return $this->model->where('grievanceId', $grievanceId)->get();
    }

    public function deleteByCommitteeMemberId($grievanceId)
    {
        return $this->model->where('grievanceId', $grievanceId)->delete();
    }

}
