<?php

namespace App\Containers\PlanDepartQuestion\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UpdatePlanDepartQuestionAction extends Action
{
    public function run(Request $request)
    {
        $data = $request->sanitizeInput([
            'question',
            'answers',
        ]);

        $plan_depart_question = Apiato::call('PlanDepartQuestion@UpdatePlanDepartQuestionTask', [$request->id, $data]);

        return $plan_depart_question;
    }
}
