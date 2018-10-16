<?php

namespace App\Containers\Report\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

/**
 * Class ReportRepository
 */
class ReportRepository extends Repository
{

    /**
     * The Container Name.
     * Must be set when the model has a different name than the container
     */
    protected $container = 'Report';

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];

}
