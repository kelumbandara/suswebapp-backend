<?php
namespace App\Repositories\All\SaAttritionRecord;

use App\Models\SaAttritionRecord;
use App\Repositories\Base\BaseRepository;

class AttritionRecordRepository extends BaseRepository implements AttritionRecordInterface
{
    /**
     * @var SaAttritionRecord
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAttritionRecord $model
     */
    public function __construct(SaAttritionRecord $model)
    {
        $this->model = $model;
    }


}
