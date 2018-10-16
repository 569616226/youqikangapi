<?php

namespace App\Containers\Revision\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllRevisionsAction extends Action
{
    public function run(Request $request)
    {
        $revisions = Apiato::call('Revision@GetAllRevisionsTask', [], ['ordered']);

        return $revisions;
    }
}
