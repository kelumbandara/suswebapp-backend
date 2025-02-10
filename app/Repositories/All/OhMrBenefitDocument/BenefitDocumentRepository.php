<?php
namespace App\Repositories\All\OhMrBenefitDocument;

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
    public function deleteByBenefitRequestId($benefitRequestId)
    {
        return $this->model->where('benefitRequestId', $benefitRequestId)->delete();
    }

    public function findByBenefitRequestId($benefitRequestId)
    {
        return $this->model->where('benefitRequestId', $benefitRequestId)->get();
    }

}
