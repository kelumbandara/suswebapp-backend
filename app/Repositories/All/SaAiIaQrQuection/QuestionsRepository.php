<?php
namespace App\Repositories\All\SaAiIaQrQuection;

use App\Models\SaAiIaQrQuestions;
use App\Repositories\Base\BaseRepository;

class QuestionsRepository extends BaseRepository implements QuestionsInterface
{
    /**
     * @var SaAiIaQrQuestions
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiIaQrQuestions $model
     */
    public function __construct(SaAiIaQrQuestions $model)
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

    public function findByQueGroupId($queGroupIds)
    {
        if (is_array($queGroupIds)) {
            return $this->model->whereIn('queGroupId', $queGroupIds)->get();
        }

        return $this->model->where('queGroupId', $queGroupIds)->get();
    }

    public function deleteByQueGroupId($queGroupId)
    {
        return $this->model->where('queGroupId', $queGroupId)->delete();
    }

    public function findByQueGroupIdAndQuestionRecoId(int $queGroupId, int $questionRecoId)
    {
        return $this->model->where('queGroupId', $queGroupId)
            ->where('questionRecoId', $questionRecoId)
            ->first();
    }

}
