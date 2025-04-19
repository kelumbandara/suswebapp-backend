<?php
namespace App\Repositories\All\SaAiIaAnswerRecode;

use App\Models\SaAiIaAnswerRecode;
use App\Repositories\Base\BaseRepository;

class AnswerRecodeRepository extends BaseRepository implements AnswerRecodeInterface
{
    /**
     * @var SaAiIaAnswerRecode
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiIaAnswerRecode $model
     */
    public function __construct(SaAiIaAnswerRecode $model)
    {
        $this->model = $model;
    }
    public function findByIntarnalAuditId($intarnalAuditId)
    {
        return $this->model->where('intarnalAuditId', $intarnalAuditId)->get();
    }

    public function deleteByIntarnalAuditId($intarnalAuditId)
    {
        return $this->model->where('intarnalAuditId', $intarnalAuditId)->delete();
    }

}
