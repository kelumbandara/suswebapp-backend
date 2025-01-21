<?php
namespace App\Repositories\All\SAInternalAudits;

use App\Models\S_A_InternalAudit;
use App\Repositories\Base\BaseRepository;

class InternalAuditRepository extends BaseRepository implements InternalAuditInterface
{
    /**
     * @var S_A_InternalAudit
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param S_A_InternalAudit $model
     */
    public function __construct(S_A_InternalAudit $model)
    {
        $this->model = $model;
    }



}
