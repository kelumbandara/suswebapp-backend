<?php
namespace App\Repositories\All\Department;

use App\Models\Department;
use App\Repositories\Base\BaseRepository;

class DepartmentRepository extends BaseRepository implements DepartmentInterface
{
    /**
     * @var Department
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param Department $model
     */
    public function __construct(Department $model)
    {
        $this->model = $model;
    }



}
