<?php

namespace App\Repositories\All\OhMrBenefitDocument;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface BenefitDocumentInterface extends EloquentRepositoryInterface {
    public function findByDocumentId(int $documentId);
    public function deleteByDocumentId(int $documentId);
}
