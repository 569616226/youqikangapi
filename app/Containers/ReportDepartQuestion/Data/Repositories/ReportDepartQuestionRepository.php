<?php

namespace App\Containers\ReportDepartQuestion\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

/**
 * Class ReportDepartQuestionRepository
 */
class ReportDepartQuestionRepository extends Repository
{

    /**
     * The Container Name.
     * Must be set when the model has a different name than the container
     */
    protected $container = 'ReportDepartQuestion';

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];

}
