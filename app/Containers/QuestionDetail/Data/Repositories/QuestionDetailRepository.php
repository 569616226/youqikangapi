<?php

namespace App\Containers\QuestionDetail\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

/**
 * Class QuestionDetailRepository
 */
class QuestionDetailRepository extends Repository
{

    /**
     * The Container Name.
     * Must be set when the model has a different name than the container
     */
    protected $container = 'QuestionDetail';

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];

}
