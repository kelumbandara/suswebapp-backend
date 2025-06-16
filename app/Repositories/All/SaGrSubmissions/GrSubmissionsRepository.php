<?php
namespace App\Repositories\All\SaGrSubmissions;

use App\Models\SaGrSubmissions;
use App\Repositories\Base\BaseRepository;

class GrSubmissionsRepository extends BaseRepository implements GrSubmissionsInterface
{
    /**
     * @var SaGrSubmissions
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaGrSubmissions $model
     */
    public function __construct(SaGrSubmissions $model)
    {
        $this->model = $model;
    }


}
