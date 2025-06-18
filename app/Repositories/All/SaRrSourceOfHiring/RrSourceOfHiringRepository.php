<?php
namespace App\Repositories\All\SaRrSourceOfHiring;

use App\Models\SaRrSourceOfHiring;
use App\Repositories\Base\BaseRepository;

class RrSourceOfHiringRepository extends BaseRepository implements RrSourceOfHiringInterface
{
    /**
     * @var SaRrSourceOfHiring
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaRrSourceOfHiring $model
     */
    public function __construct(SaRrSourceOfHiring $model)
    {
        $this->model = $model;
    }


}
