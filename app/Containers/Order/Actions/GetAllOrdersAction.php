<?php

namespace App\Containers\Order\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllOrdersAction extends Action
{
    public function run(Request $request)
    {
        $orders = Apiato::call('Order@GetAllOrdersTask', [true], [
            'ordered'
        ]);

        return $orders;
    }
}
