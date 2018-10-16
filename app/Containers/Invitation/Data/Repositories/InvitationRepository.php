<?php

namespace App\Containers\Invitation\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

/**
 * Class InvitationRepository
 */
class InvitationRepository extends Repository
{

    /**
     * The Container Name.
     * Must be set when the model has a different name than the container
     */
    protected $container = 'Invitation';

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];

}
