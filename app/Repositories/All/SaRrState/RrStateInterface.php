<?php
namespace App\Repositories\All\SaRrState;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface RrStateInterface extends EloquentRepositoryInterface
{
    public function findByCountryId(int $countryId);

}
