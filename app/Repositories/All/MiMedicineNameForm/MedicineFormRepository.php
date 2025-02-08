<?php
namespace App\Repositories\All\MiMedicineNameForm;

use App\Models\HsOhMiMnForm;
use App\Repositories\Base\BaseRepository;

class MedicineFormRepository extends BaseRepository implements MedicineFormInterface
{
    /**
     * @var HsOhMiMnForm
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsOhMiMnForm $model
     */
    public function __construct(HsOhMiMnForm $model)
    {
        $this->model = $model;
    }

}
