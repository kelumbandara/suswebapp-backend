<?php
namespace App\Repositories\All\ProcessType;

use App\Models\ProcessType;
use App\Repositories\Base\BaseRepository;

class ProcessTypeRepository extends BaseRepository implements ProcessTypeInterface
{
    /**
     * @var ProcessType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param ProcessType $model
     */
    public function __construct(ProcessType $model)
    {
        $this->model = $model;
    }



}
