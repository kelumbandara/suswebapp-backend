<?php
namespace App\Repositories\All\Auditee;

use App\Models\Auditee;
use App\Repositories\All\Auditee\AuditeeInterface;
use App\Repositories\Base\BaseRepository;

class   AuditeeRepository extends BaseRepository implements AuditeeInterface
{
    /**
     * @var Auditee
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param Auditee $model
     */
    public function __construct(Auditee $model)
    {
        $this->model = $model;
    }



}
