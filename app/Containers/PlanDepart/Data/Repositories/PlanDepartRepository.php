<?php

namespace App\Containers\PlanDepart\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

/**
 * Class PlanDepartRepository
 */
class PlanDepartRepository extends Repository
{

    /**
     * The Container Name.
     * Must be set when the model has a different name than the container
     */
    protected $container = 'PlanDepart';

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];

}
