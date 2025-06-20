<?php
namespace App\Repositories\All\SaArEmploymentClassification;

use App\Models\SaArEmploymentClassification;
use App\Repositories\Base\BaseRepository;

class ArEmploymentClassificationRepository extends BaseRepository implements ArEmploymentClassificationInterface
{
    /**
     * @var SaArEmploymentClassification
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaArEmploymentClassification $model
     */
    public function __construct(SaArEmploymentClassification $model)
    {
        $this->model = $model;
    }


}
