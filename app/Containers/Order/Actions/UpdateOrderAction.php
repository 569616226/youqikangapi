<?php

namespace App\Containers\Order\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UpdateOrderAction extends Action
{
    public function run(Request $request)
    {

        $data = [
            'name' => $request->name,
        ];

        $order = Apiato::call('Order@UpdateOrderTask', [$request->id, $data]);

        return $order;
    }
}
