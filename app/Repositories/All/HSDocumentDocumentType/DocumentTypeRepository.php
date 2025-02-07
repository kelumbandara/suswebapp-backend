<?php
namespace App\Repositories\All\HSDocumentDocumentType;

use App\Models\HsDocumentDocumentType;
use App\Repositories\Base\BaseRepository;

class DocumentTypeRepository extends BaseRepository implements DocumentTypeInterface
{
    /**
     * @var HsDocumentDocumentType
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsDocumentDocumentType $model
     */
    public function __construct(HsDocumentDocumentType $model)
    {
        $this->model = $model;
    }



}
