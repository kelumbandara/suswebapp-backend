<?php
namespace App\Repositories\All\SaAiIaAuditTitle;

use App\Models\SaAiIaAuditTitle;
use App\Repositories\Base\BaseRepository;

class AuditTitleRepository extends BaseRepository implements AuditTitleInterface
{
    /**
     * @var SaAiIaAuditTitle
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiIaAuditTitle $model
     */
    public function __construct(SaAiIaAuditTitle $model)
    {
        $this->model = $model;
    }


}
