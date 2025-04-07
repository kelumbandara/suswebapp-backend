<?php
namespace App\Repositories\All\SaAiInternalAuditRecode;

use App\Models\SaAiInternalAuditRecode;
use App\Repositories\Base\BaseRepository;

class InternalAuditRecodeRepository extends BaseRepository implements InternalAuditRecodeInterface
{
    /**
     * @var SaAiInternalAuditRecode
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiInternalAuditRecode $model
     */
    public function __construct(SaAiInternalAuditRecode $model)
    {
        $this->model = $model;
    }
    public function getByApproverId($approverId)
    {
        return $this->model->where('approverId', $approverId)->get();
    }


}
