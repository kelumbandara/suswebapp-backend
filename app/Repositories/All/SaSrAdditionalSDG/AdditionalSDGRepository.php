<?php
namespace App\Repositories\All\SaSrAdditionalSDG;

use App\Models\SaSSrAdditionalSdg;
use App\Repositories\Base\BaseRepository;

class AdditionalSDGRepository extends BaseRepository implements AdditionalSDGInterface
{
    /**
     * @var SaSSrAdditionalSdg
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaSSrAdditionalSdg $model
     */
    public function __construct(SaSSrAdditionalSdg $model)
    {
        $this->model = $model;
    }


}
