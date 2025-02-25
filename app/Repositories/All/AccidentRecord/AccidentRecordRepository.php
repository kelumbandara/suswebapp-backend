<?php
namespace App\Repositories\All\AccidentRecord;

use App\Models\HsAiAccidentRecord;
use App\Repositories\Base\BaseRepository;

class AccidentRecordRepository extends BaseRepository implements AccidentRecordInterface
{
    /**
     * @var HsAiAccidentRecord
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsAiAccidentRecord $model
     */
    public function __construct(HsAiAccidentRecord $model)
    {
        $this->model = $model;
    }

    public function getByAssigneeId($assigneeId)
    {
        return $this->model->where('assigneeId', $assigneeId)->get();
    }

}
