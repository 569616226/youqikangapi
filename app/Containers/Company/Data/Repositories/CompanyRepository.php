<?php

namespace App\Containers\Company\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

/**
 * Class CompanyRepository
 */
class CompanyRepository extends Repository
{

    /**
     * The Container Name.
     * Must be set when the model has a different name than the container
     */
    protected $container = 'Company';

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'   => '=',
        'name' => 'like',
        // ...
    ];

}
