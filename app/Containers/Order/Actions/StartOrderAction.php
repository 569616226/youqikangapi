<?php

namespace App\Containers\Order\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class StartOrderAction extends Action
{
    public function run(Request $request)
    {
        $order = Apiato::call('Order@UpdateOrderTask', [$request->id, ['start_at' => now(), 'status' => '进行中']]);

        return $order;
    }
}
