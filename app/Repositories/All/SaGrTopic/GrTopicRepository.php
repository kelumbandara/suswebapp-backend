<?php
namespace App\Repositories\All\SaGrTopic;

use App\Models\SaGrTopic;
use App\Repositories\Base\BaseRepository;

class GrTopicRepository extends BaseRepository implements GrTopicInterface
{
    /**
     * @var SaGrTopic
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaGrTopic $model
     */
    public function __construct(SaGrTopic $model)
    {
        $this->model = $model;
    }


}
