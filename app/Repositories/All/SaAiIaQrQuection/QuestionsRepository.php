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
    public function findByQuectionRecoId($quectionRecoId)
    {
        return $this->model->where('quectionRecoId', $quectionRecoId)->get();
    }

    public function deleteByQuectionRecoId($quectionRecoId)
    {
        return $this->model->where('quectionRecoId', $quectionRecoId)->delete();
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

    public function findByQueGroupIdAndQuectionRecoId(int $queGroupId, int $quectionRecoId)
    {
        return $this->model->where('queGroupId', $queGroupId)
            ->where('quectionRecoId', $quectionRecoId)
            ->first(); 
    }

}
