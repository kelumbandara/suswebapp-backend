<?php
namespace App\Repositories\All\MiMedicineRequest;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface MedicineRequestInterface extends EloquentRepositoryInterface
{
    public function getByAssigneeId(int $assigneeId);

}
