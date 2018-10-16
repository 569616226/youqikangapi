<?php

namespace App\Containers\PlanDepart\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UpdatePlanDepartAction extends Action
{
    public function run(Request $request)
    {
        $data = $request->sanitizeInput([
            'name',
            'icon',
        ]);

        $plan_depart = Apiato::call('PlanDepart@UpdatePlanDepartTask', [$request->id, $data]);

        return $plan_depart;
    }
}
