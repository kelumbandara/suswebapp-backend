<?php
namespace App\Repositories\All\IncidentRecord;

use App\Repositories\Base\EloquentRepositoryInterface;

interface IncidentRecodeInterface extends EloquentRepositoryInterface
{
    public function getByAssigneeId(int $assigneeId);

}
