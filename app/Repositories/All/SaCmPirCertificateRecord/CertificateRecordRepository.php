<?php
namespace App\Repositories\All\SaCmPirCertificateRecord;

use App\Models\SaCmPirCertificateRecord;
use App\Repositories\Base\BaseRepository;

class CertificateRecordRepository extends BaseRepository implements CertificateRecordInterface
{
    /**
     * @var SaCmPirCertificateRecord
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaCmPirCertificateRecord $model
     */
    public function __construct(SaCmPirCertificateRecord $model)
    {
        $this->model = $model;
    }


}
