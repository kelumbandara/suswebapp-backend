<?php
namespace App\Repositories\All\SaAiInternalAuditFactory;

use App\Models\SaAiInternalAuditFactory;
use App\Repositories\Base\BaseRepository;

class InternalAuditFactoryRepository extends BaseRepository implements InternalAuditFactoryInterface
{
    /**
     * @var SaAiInternalAuditFactory
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiInternalAuditFactory $model
     */
    public function __construct(SaAiInternalAuditFactory $model)
    {
        $this->model = $model;
    }


}
