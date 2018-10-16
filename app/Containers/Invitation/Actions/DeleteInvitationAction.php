<?php

namespace App\Containers\Invitation\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class DeleteInvitationAction extends Action
{
    public function run(Request $request)
    {
        return Apiato::call('Invitation@DeleteInvitationTask', [$request->id]);
    }
}
