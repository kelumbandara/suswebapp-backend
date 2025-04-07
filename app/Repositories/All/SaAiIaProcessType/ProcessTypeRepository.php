<?php
namespace App\Repositories\All\SaAiIaProcessType;

use App\Models\SaAiIaProcessType;
use App\Repositories\Base\BaseRepository;

class ProcessTypeRepository extends BaseRepository implements ProcessTypeInterface
{
    /**
     * @var SaAiIaProcessType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiIaProcessType $model
     */
    public function __construct(SaAiIaProcessType $model)
    {
        $this->model = $model;
    }


}
