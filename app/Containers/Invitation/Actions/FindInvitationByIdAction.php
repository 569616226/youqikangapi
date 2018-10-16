<?php

namespace App\Containers\Invitation\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class FindInvitationByIdAction extends Action
{
    public function run(Request $request)
    {
        $invitation = Apiato::call('Invitation@FindInvitationByIdTask', [$request->id]);

        return $invitation;
    }
}
