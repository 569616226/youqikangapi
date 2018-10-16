<?php

namespace App\Containers\Plan\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class FindPlanByIdAction extends Action
{
    public function run(Request $request)
    {
        $plan = Apiato::call('Plan@FindPlanByIdTask', [$request->id]);

        return $plan;
    }
}
