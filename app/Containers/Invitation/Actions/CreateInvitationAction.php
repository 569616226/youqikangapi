<?php

namespace App\Containers\Invitation\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class CreateInvitationAction extends Action
{
    public function run(Request $request)
    {

        $data = [

            'code'       => rand(100000, 999999),
            'report_id'  => $request->id,
            'depart_ids' => $request->depart_ids,
            'user_id'    => \Auth::user()->id,

        ];

        $invitation = Apiato::call('Invitation@CreateInvitationTask', [$data]);

        return $invitation;
    }

}
