<?php

namespace App\Containers\Message\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class FindMessageByIdAction extends Action
{
    public function run(Request $request)
    {
        $message = Apiato::call('Message@FindMessageByIdTask', [$request->id]);

        return $message;
    }
}
