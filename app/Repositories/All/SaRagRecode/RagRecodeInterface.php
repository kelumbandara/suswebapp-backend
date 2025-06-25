<?php
namespace App\Repositories\All\SaRagRecode;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface RagRecodeInterface extends EloquentRepositoryInterface
{
    public function filterByParams($startDate, $endDate);
    public function filterByYear($year);

}
