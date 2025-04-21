<?php
namespace App\Repositories\All\SaCmChemicalManagementRecode;

use App\Models\SaCmChemicalManagemantRecode;
use App\Repositories\Base\BaseRepository;

class ChemicalManagementRecodeRepository extends BaseRepository implements ChemicalManagementRecodeInterface
{
    /**
     * @var SaCmChemicalManagemantRecode
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaCmChemicalManagemantRecode $model
     */
    public function __construct( SaCmChemicalManagemantRecode $model)
    {
        $this->model = $model;
    }

    public function getByReviewerId($reviewerId)
    {
        return $this->model->where('reviewerId', $reviewerId)->get();
    }


}
