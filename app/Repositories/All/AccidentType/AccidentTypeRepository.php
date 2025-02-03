<?php
namespace App\Repositories\All\AccidentType;

use App\Models\HsAiAccidentType;
use App\Repositories\Base\BaseRepository;

class  AccidentTypeRepository extends BaseRepository implements AccidentTypeInterface
{
    /**
     * @var HsAiAccidentType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsAiAccidentType $model
     */
    public function __construct(HsAiAccidentType $model)
    {
        $this->model = $model;
    }



}
