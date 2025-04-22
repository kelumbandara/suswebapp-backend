<?php
namespace App\Repositories\All\SaETargetSetting;

use App\Models\SaETargetSettingRecode;
use App\Repositories\Base\BaseRepository;

class TargetSettingRecodeRepository extends BaseRepository implements TargetSettingRecodeInterface
{
    /**
     * @var SaETargetSettingRecode
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaETargetSettingRecode $model
     */
    public function __construct(SaETargetSettingRecode $model)
    {
        $this->model = $model;
    }

    public function getByAssigneeId($assigneeId)
    {
        return $this->model->where('assigneeId', $assigneeId)->get();
    }

}
