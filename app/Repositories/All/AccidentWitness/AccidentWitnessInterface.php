<?php

namespace App\Repositories\All\AccidentWitness;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface AccidentWitnessInterface extends EloquentRepositoryInterface {

    public function findByAccidentId(int $accidentId);
    
}
