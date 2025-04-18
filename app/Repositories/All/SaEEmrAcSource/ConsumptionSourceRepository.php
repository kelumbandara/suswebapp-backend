<?php
namespace App\Repositories\All\SaEEmrAcSource;

use App\Models\SaETsSource;
use App\Repositories\Base\BaseRepository;
class ConsumptionSourceRepository extends BaseRepository implements ConsumptionSourceInterface
{
    /**
     * @var SaETsSource
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaETsSource $model
     */
    public function __construct(SaETsSource $model)
    {
        $this->model = $model;
    }


}
