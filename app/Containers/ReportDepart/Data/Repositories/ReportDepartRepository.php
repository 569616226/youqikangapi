<?php

namespace App\Containers\ReportDepart\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

/**
 * Class ReportDepartRepository
 */
class ReportDepartRepository extends Repository
{

    /**
     * The Container Name.
     * Must be set when the model has a different name than the container
     */
    protected $container = 'ReportDepart';

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];

}
