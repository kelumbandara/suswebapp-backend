<?php
namespace App\Repositories\All\SaRrDesignationName;

use App\Models\SaRrDesignationName;
use App\Repositories\Base\BaseRepository;

class RrDesignationNameRepository extends BaseRepository implements RrDesignationNameInterface
{
    /**
     * @var SaRrDesignationName
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaRrDesignationName $model
     */
    public function __construct(SaRrDesignationName $model)
    {
        $this->model = $model;
    }


}
