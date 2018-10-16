<?php

namespace App\Containers\Message\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class CreateMessageAction extends Action
{
    public function run(Request $request)
    {
        $data = $request->sanitizeInput([
            'content'
        ]);

        $message = Apiato::call('Message@CreateMessageTask', [$data]);

        return $message;
    }
}
