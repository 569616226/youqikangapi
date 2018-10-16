<?php

namespace App\Containers\PlanDepartQuestion\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

/**
 * Class PlanDepartQuestionRepository
 */
class PlanDepartQuestionRepository extends Repository
{

    /**
     * The Container Name.
     * Must be set when the model has a different name than the container
     */
    protected $container = 'PlanDepartQuestion';

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];

}
