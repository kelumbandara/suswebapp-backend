<?php
namespace App\Repositories\All\MiMedicineName;

use App\Models\HsOhMiMedicineName;
use App\Repositories\Base\BaseRepository;

class MedicineNameRepository extends BaseRepository implements MedicineNameInterface
{
    /**
     * @var HsOhMiMedicineName
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsOhMiMedicineName $model
     */
    public function __construct(HsOhMiMedicineName $model)
    {
        $this->model = $model;
    }

}
