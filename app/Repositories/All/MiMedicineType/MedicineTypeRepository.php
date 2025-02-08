<?php
namespace App\Repositories\All\MiMedicineType;

use App\Models\HsOhMiMnMedicineType;
use App\Repositories\Base\BaseRepository;

class MedicineTypeRepository extends BaseRepository implements MedicineTypeInterface
{
    /**
     * @var HsOhMiMnMedicineType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsOhMiMnMedicineType $model
     */
    public function __construct(HsOhMiMnMedicineType $model)
    {
        $this->model = $model;
    }


}
