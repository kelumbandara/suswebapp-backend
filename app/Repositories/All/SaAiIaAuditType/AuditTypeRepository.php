<?php
namespace App\Repositories\All\SaAiIaAuditType;

use App\Models\SaAiIaAuditType;
use App\Repositories\Base\BaseRepository;

class AuditTypeRepository extends BaseRepository implements AuditTypeInterface
{
    /**
     * @var SaAiIaAuditType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiIaAuditType $model
     */
    public function __construct(SaAiIaAuditType $model)
    {
        $this->model = $model;
    }


}
