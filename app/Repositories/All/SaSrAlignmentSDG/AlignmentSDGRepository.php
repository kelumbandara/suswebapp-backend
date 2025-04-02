<?php
namespace App\Repositories\All\SaSrAlignmentSDG;

use App\Models\SaSSrAlignmentSdg;
use App\Repositories\Base\BaseRepository;

class AlignmentSDGRepository extends BaseRepository implements AlignmentSDGInterface
{
    /**
     * @var SaSSrAlignmentSdg
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaSSrAlignmentSdg $model
     */
    public function __construct(SaSSrAlignmentSdg $model)
    {
        $this->model = $model;
    }


}
