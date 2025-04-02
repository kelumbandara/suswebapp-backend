<?php
namespace App\Repositories\All\SaSrSDG;

use App\Models\SaSSrSdg;
use App\Repositories\Base\BaseRepository;

class SrSdgRepository extends BaseRepository implements SrSdgInterface
{
    /**
     * @var SaSSrSdg
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaSSrSdg $model
     */
    public function __construct(SaSSrSdg $model)
    {
        $this->model = $model;
    }


}
