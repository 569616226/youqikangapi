<?php

namespace App\Containers\Order\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class DeleteOrderAction extends Action
{
    public function run(Request $request)
    {
        return Apiato::call('Order@DeleteOrderTask', [$request->id]);
    }
}
