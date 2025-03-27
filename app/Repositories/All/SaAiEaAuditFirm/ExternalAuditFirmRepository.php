<?php
namespace App\Repositories\All\SaAiEaAuditFirm;

use App\Models\SaAiEaAuditFirm;
use App\Repositories\Base\BaseRepository;

class ExternalAuditFirmRepository extends BaseRepository implements ExternalAuditFirmInterface
{
    /**
     * @var SaAiEaAuditFirm
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiEaAuditFirm $model
     */
    public function __construct(SaAiEaAuditFirm $model)
    {
        $this->model = $model;
    }


}
