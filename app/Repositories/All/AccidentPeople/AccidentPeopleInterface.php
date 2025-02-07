<?php

namespace App\Repositories\All\AccidentPeople;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface AccidentPeopleInterface extends EloquentRepositoryInterface {
    public function findByAccidentId(int $accidentId);

}
