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

    public function getByApproverId($approverId)
    {
        return $this->model->where('approverId', $approverId)->get();
    }
    public function filterByYearMonthDivision($year, $month, $division)
    {
        return $this->model
            ->whereYear('updated_at', $year)
            ->whereMonth('updated_at', date('m', strtotime($month))) 
            ->where('division', $division)
            ->get();
    }


}
