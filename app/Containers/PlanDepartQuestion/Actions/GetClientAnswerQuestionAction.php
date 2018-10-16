<?php

namespace App\Containers\PlanDepartQuestion\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetClientAnswerQuestionAction extends Action
{
    public function run(Request $request)
    {
        $data = [
            'client_answer'        => $request->client_answer,
            'client_answer_editer' => \Auth::user()->username,
            'status'               => '调查中',
        ];

        $plan_depart_question = Apiato::call('PlanDepartQuestion@UpdateMobilePlanDepartQuestionTask', [$request->id, $data]);

        return $plan_depart_question;
    }
}
