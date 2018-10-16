<?php

namespace App\Containers\Order\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class FrozenOrderAction extends Action
{
    public function run(Request $request)
    {
        $order = Apiato::call('Order@UpdateOrderTask', [$request->id, ['status' => '已冻结']]);

        return $order;
    }
}
