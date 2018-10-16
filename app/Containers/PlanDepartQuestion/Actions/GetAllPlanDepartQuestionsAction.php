<?php

namespace App\Containers\PlanDepartQuestion\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllPlanDepartQuestionsAction extends Action
{
    public function run(Request $request)
    {
        $plan_depart_questions = Apiato::call('PlanDepartQuestion@GetAllPlanDepartQuestionsTask', [true, $request->id], [
            'ordered'
        ]);

        return $plan_depart_questions;
    }
}
