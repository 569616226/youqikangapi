<?php

namespace App\Containers\Plan\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

/**
 * Class PlanRepository
 */
class PlanRepository extends Repository
{

    /**
     * The Container Name.
     * Must be set when the model has a different name than the container
     */
    protected $container = 'Plan';

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];

}
