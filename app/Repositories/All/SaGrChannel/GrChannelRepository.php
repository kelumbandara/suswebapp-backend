<?php
namespace App\Repositories\All\SaGrChannel;

use App\Models\SaGrChannel;
use App\Repositories\Base\BaseRepository;

class GrChannelRepository extends BaseRepository implements GrChannelInterface
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
    public function __construct(SaGrChannel $model)
    {
        $this->model = $model;
    }


}
