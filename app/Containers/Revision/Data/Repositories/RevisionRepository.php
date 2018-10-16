<?php

namespace App\Containers\Revision\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

/**
 * Class RevisionRepository
 */
class RevisionRepository extends Repository
{

    /**
     * The Container Name.
     * Must be set when the model has a different name than the container
     */
    protected $container = 'Revision';

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];

}
