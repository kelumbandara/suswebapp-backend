<?php
namespace App\Repositories\All\SaRagRecode;

use App\Models\SaRagRecord;
use App\Repositories\Base\BaseRepository;

class RagRecodeRepository extends BaseRepository implements RagRecodeInterface
{
    /**
     * @var SaRagRecord
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaRagRecord $model
     */
    public function __construct(SaRagRecord $model)
    {
        $this->model = $model;
    }


}
