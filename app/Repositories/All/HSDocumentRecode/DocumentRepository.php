<?php
namespace App\Repositories\All\HSDocumentRecode;

use App\Models\HsDocumentRecode;
use App\Repositories\Base\BaseRepository;

class DocumentRepository extends BaseRepository implements DocumentInterface
{
    /**
     * @var HsDocumentRecode
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HsDocumentRecode $model
     */
    public function __construct(HsDocumentRecode $model)
    {
        $this->model = $model;
    }



}
