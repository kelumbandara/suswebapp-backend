<?php
namespace App\Repositories\All\SaETsSource;

use App\Models\SaETsSource;
use App\Repositories\Base\BaseRepository;

class TsSourceRepository extends BaseRepository implements TsSourceInterface
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
