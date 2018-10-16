<?php

namespace App\Containers\PlanDepart\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class FindPlanDepartByIdAction extends Action
{
    public function run(Request $request)
    {
        $plan_depart = Apiato::call('PlanDepart@FindPlanDepartByIdTask', [$request->id]);

        return $plan_depart;
    }
}
