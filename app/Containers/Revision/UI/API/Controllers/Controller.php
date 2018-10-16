<?php

namespace App\Containers\Revision\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Revision\UI\API\Requests\GetAllRevisionsRequest;
use App\Containers\Revision\UI\API\Transformers\RevisionTransformer;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller
 *
 * @package App\Containers\Revision\UI\API\Controllers
 */
class Controller extends ApiController
{

    /**
     * @param GetAllRevisionsRequest $request
     * @return array
     */
    public function getAllRevisions(GetAllRevisionsRequest $request)
    {
        $revisions = Apiato::call('Revision@GetAllRevisionsAction', [$request]);

        return $this->transform($revisions, RevisionTransformer::class);
    }


}
