<?php
namespace App\Repositories\All\SaRrState;

use App\Models\SaRrState;
use App\Repositories\Base\BaseRepository;

class RrStateRepository extends BaseRepository implements RrStateInterface
{
    /**
     * @var SaRrState
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaRrState $model
     */
    public function __construct(SaRrState $model)
    {
        $this->model = $model;
    }


}
