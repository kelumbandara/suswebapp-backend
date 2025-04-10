<?php
namespace App\Repositories\All\SaAiIaInternalAuditee;

use App\Models\SaAiIaInternalAuditee;
use App\Models\SaSSrAdditionalSdg;
use App\Repositories\Base\BaseRepository;

class InternalAuditeeRepository extends BaseRepository implements InternalAuditeeInterface
{
    /**
     * @var SaAiIaInternalAuditee
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiIaInternalAuditee $model
     */
    public function __construct(SaAiIaInternalAuditee $model)
    {
        $this->model = $model;
    }


}
