<?php
namespace App\Repositories\All\SaAiEaAuditType;

use App\Models\SaAiEaAuditType;
use App\Repositories\Base\BaseRepository;

class ExternalAuditTypeRepository extends BaseRepository implements ExternalAuditTypeInterface
{
    /**
     * @var SaAiEaAuditType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiEaAuditType $model
     */
    public function __construct(SaAiEaAuditType $model)
    {
        $this->model = $model;
    }


}
