<?php

namespace App\Repositories\All\HazardAndRisk;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface HazardAndRiskInterface extends EloquentRepositoryInterface {
    public function countAll();
    public function countByStatus($status);
    public function sumField($field);
    public function countByDivision($division);
    public function getAllDivisions();
    public function getDistinctDivisions();

}
