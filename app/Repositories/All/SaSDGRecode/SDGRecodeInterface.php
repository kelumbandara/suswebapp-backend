<?php
namespace App\Repositories\All\SaSDGRecode;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface SDGRecodeInterface extends EloquentRepositoryInterface
{
    public function getByAssigneeId(int $assigneeId);

}
