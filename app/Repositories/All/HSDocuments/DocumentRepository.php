<?php

namespace App\Repositories\All\HSDocuments;

use App\Models\HSDocument;
use App\Repositories\Base\BaseRepository;

// repository Class
class DocumentRepository extends BaseRepository implements DocumentInterface
{
    /**
     * @var HSDocument
     */
    protected $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct(HSDocument $model)
    {
        $this->model = $model;
    }
}
