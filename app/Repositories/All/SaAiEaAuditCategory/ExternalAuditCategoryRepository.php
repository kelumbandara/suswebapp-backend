<?php
namespace App\Repositories\All\SaAiEaAuditCategory;

use App\Models\SaAiEaAuditCategory;
use App\Repositories\Base\BaseRepository;

class ExternalAuditCategoryRepository extends BaseRepository implements ExternalAuditCategoryInterface
{
    /**
     * @var SaAiEaAuditCategory
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiEaAuditCategory $model
     */
    public function __construct(SaAiEaAuditCategory $model)
    {
        $this->model = $model;
    }


}
