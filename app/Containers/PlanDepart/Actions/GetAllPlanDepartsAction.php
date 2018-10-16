<?php

namespace App\Containers\PlanDepart\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllPlanDepartsAction extends Action
{
    public function run(Request $request)
    {
        $plan_departs = Apiato::call('PlanDepart@GetAllPlanDepartsTask', [true, $request->id], [
            'ordered'
        ]);

        return $plan_departs;
    }
}
