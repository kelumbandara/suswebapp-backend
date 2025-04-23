<?php
namespace App\Repositories\All\SaAiIaQrGroupRecode;

use App\Models\SaAiIaQrGroupRecode;
use App\Repositories\Base\BaseRepository;

class GroupRecodeRepository extends BaseRepository implements GroupRecodeInterface
{
    /**
     * @var SaAiIaQrGroupRecode
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiIaQrGroupRecode $model
     */
    public function __construct(SaAiIaQrGroupRecode $model)
    {
        $this->model = $model;
    }
    public function findByQuestionRecoId($questionRecoId)
    {
        return $this->model->where('questionRecoId', $questionRecoId)->get();
    }

    public function deleteByQuestionRecoId($questionRecoId)
    {
        return $this->model->where('questionRecoId', $questionRecoId)->delete();
    }

}
