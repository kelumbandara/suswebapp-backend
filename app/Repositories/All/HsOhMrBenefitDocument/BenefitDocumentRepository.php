<?php
namespace App\Repositories\All\HsOhMrBenefitDocument;

use App\Models\HsOhMrBenefitDocument;
use App\Repositories\Base\BaseRepository;

class BenefitDocumentRepository extends BaseRepository implements BenefitDocumentInterface
{
    /**
     * @var HsOhMrBenefitDocument
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsOhMrBenefitDocument $model
     */
    public function __construct(HsOhMrBenefitDocument $model)
    {
        $this->model = $model;
    }
    public function findByBenefitId($benefitId)
    {
        return $this->model->where('benefitId', $benefitId)->get();
    }

    public function deleteByBenefitId($benefitId)
    {
        return $this->model->where('benefitId', $benefitId)->delete();
    }




}
