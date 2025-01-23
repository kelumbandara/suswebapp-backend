<?php
namespace App\Repositories\All\SAExternalAudits;

use App\Models\S_A_ExternalAudit;
use App\Repositories\Base\BaseRepository;

class ExternalAuditRepository extends BaseRepository implements ExternalAuditInterface
{
    /**
     * @var S_A_ExternalAudit
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param S_A_ExternalAudit  $model
     */
    public function __construct(S_A_ExternalAudit $model)
    {
        $this->model = $model;
    }



}
