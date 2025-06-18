<?php
namespace App\Repositories\All\SaRrCountryName;

use App\Models\SaRrCountryName;
use App\Repositories\Base\BaseRepository;

class RrCountryNameRepository extends BaseRepository implements RrCountryNameInterface
{
    /**
     * @var SaRrCountryName
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaRrCountryName $model
     */
    public function __construct(SaRrCountryName $model)
    {
        $this->model = $model;
    }


}
