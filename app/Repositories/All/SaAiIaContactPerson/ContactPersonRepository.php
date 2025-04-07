<?php
namespace App\Repositories\All\SaAiIaContactPerson;

use App\Models\SaAiIaFContactPerson;
use App\Repositories\Base\BaseRepository;

class ContactPersonRepository extends BaseRepository implements ContactPersonInterface
{
    /**
     * @var SaAiIaFContactPerson
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param SaAiIaFContactPerson $model
     */
    public function __construct(SaAiIaFContactPerson $model)
    {
        $this->model = $model;
    }


}
