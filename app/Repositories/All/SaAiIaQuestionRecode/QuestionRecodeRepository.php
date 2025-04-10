<?php
namespace App\Repositories\All\SaAiIaQuestionRecode;

use App\Models\SaAiIaQuestionRecode;
use App\Repositories\Base\BaseRepository;

class QuestionRecodeRepository extends BaseRepository implements QuestionRecodeInterface
{
    /**
     * @var SaAiIaQuestionRecode
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiIaQuestionRecode $model
     */
    public function __construct(SaAiIaQuestionRecode $model)
    {
        $this->model = $model;
    }


}
