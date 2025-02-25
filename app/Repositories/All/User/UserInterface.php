<?php

namespace App\Repositories\All\User;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface UserInterface extends EloquentRepositoryInterface {
    public function getUsersByAssigneeLevel(int $level);

}
