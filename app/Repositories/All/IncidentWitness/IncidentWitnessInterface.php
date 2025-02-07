<?php

namespace App\Repositories\All\IncidentWitness;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface IncidentWitnessInterface extends EloquentRepositoryInterface {
    public function findByIncidentId(int $incidentId);
    public function deleteByIncidentId(int $incidentId);
}
