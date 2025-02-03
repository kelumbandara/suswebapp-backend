<?php
namespace App\Repositories\All\AccidentInjuryType;

use App\Models\HsAiAccidentInjuryType;
use App\Repositories\Base\BaseRepository;

class  AccidentInjuryTypeRepository extends BaseRepository implements AccidentInjuryTypeInterface
{
    /**
     * @var HsAiAccidentInjuryType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsAiAccidentInjuryType $model
     */
    public function __construct(HsAiAccidentInjuryType $model)
    {
        $this->model = $model;
    }



}
