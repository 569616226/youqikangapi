<?php

namespace App\Containers\Plan\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UpdatePlanAction extends Action
{
    public function run(Request $request)
    {
        $plan_data = $request->plan_data;

        $plan = Apiato::call('Plan@UpdatePlanTask', [$request->id, $plan_data]);

        return $plan;
    }
}
