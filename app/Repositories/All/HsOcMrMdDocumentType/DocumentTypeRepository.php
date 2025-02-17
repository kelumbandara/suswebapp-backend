<?php
namespace App\Repositories\All\HsOcMrMdDocumentType;

use App\Models\HsAiIncidentCircumstances;
use App\Models\HsOcMrMdDocumentType;
use App\Repositories\Base\BaseRepository;

class DocumentTypeRepository extends BaseRepository implements DocumentTypeInterface
{
    /**
     * @var HsOcMrMdDocumentType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsOcMrMdDocumentType $model
     */
    public function __construct(HsOcMrMdDocumentType $model)
    {
        $this->model = $model;
    }



}
