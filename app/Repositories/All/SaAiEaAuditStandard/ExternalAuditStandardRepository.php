<?php
namespace App\Repositories\All\SaAiEaAuditStandard;

use App\Models\SaAiEaAuditStandard;
use App\Repositories\Base\BaseRepository;

class ExternalAuditStandardRepository extends BaseRepository implements ExternalAuditStandardInterface
{
    /**
     * @var SaAiEaAuditStandard
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiEaAuditStandard $model
     */
    public function __construct(SaAiEaAuditStandard $model)
    {
        $this->model = $model;
    }


}
