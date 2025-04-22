<?php
namespace App\Repositories\All\SaEEmrAcSource;

use App\Models\SaEEmrAcSource;
use App\Models\SaETsSource;
use App\Repositories\Base\BaseRepository;
class ConsumptionSourceRepository extends BaseRepository implements ConsumptionSourceInterface
{
    /**
     * @var SaEEmrAcSource
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaEEmrAcSource $model
     */
    public function __construct(SaEEmrAcSource $model)
    {
        $this->model = $model;
    }


}
