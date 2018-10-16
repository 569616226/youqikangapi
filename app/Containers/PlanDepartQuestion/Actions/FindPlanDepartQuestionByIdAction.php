<?php

namespace App\Containers\PlanDepartQuestion\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class FindPlanDepartQuestionByIdAction extends Action
{
    public function run(Request $request)
    {
        $plan_depart_question = Apiato::call('PlanDepartQuestion@FindPlanDepartQuestionByIdTask', [$request->id]);

        return $plan_depart_question;
    }
}
