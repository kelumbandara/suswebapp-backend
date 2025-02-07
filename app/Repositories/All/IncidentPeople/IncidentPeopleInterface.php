<?php

namespace App\Repositories\All\IncidentPeople;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface IncidentPeopleInterface extends EloquentRepositoryInterface {
    public function findByIncidentId(int $incidentId);
    public function deleteByIncidentId(int $incidentId);
}
