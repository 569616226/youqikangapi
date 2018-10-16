<?php

namespace App\Containers\Order\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class CreateOrderAction extends Action
{
    public function run(Request $request)
    {
        $data = [
            'name'         => $request->name,
            'status'       => $request->status,
            'company_id'   => $request->company_id,
            'order_number' => create_order_number(),
        ];

        /*设置启动时间*/
        if ($data['status'] == '进行中') {
            $data['start_at'] = now();
        }

        $order = Apiato::call('Order@CreateOrderTask', [$data, $request->plan_id]);

        return $order;
    }
}
