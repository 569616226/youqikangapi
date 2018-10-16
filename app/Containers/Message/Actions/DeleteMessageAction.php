<?php

namespace App\Containers\Message\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class DeleteMessageAction extends Action
{
    public function run(Request $request)
    {
        return Apiato::call('Message@DeleteMessageTask', [$request->id]);
    }
}
