<?php

namespace App\Containers\Invitation\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class GetAllInvitationsAction extends Action
{
    public function run(Request $request)
    {
        $invitations = Apiato::call('Invitation@GetAllInvitationsTask');

        return $invitations;
    }
}
