<?php

namespace App\Containers\Message\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class GetAllMessagesAction extends Action
{
    public function run(Request $request)
    {
        $messages = Apiato::call('Message@GetAllMessagesTask');

        return $messages;
    }
}
