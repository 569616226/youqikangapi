<?php

namespace App\Containers\Message\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class UpdateMessageAction extends Action
{
    public function run(Request $request)
    {
        $data = $request->sanitizeInput([
            // add your request data here
        ]);

        $message = Apiato::call('Message@UpdateMessageTask', [$request->id, $data]);

        return $message;
    }
}
