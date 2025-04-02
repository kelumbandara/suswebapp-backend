<?php
namespace App\Repositories\All\SaSrMaterialityIssues;   

use App\Models\SaSSrMaterialityIssues;
use App\Repositories\Base\BaseRepository;

class MaterialityIssuesRepository extends BaseRepository implements MaterialityIssuesInterface
{
    /**
     * @var SaSSrMaterialityIssues
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaSSrMaterialityIssues $model
     */
    public function __construct(SaSSrMaterialityIssues $model)
    {
        $this->model = $model;
    }


}
