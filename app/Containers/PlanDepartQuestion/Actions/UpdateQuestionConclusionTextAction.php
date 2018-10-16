<?php

namespace App\Containers\PlanDepartQuestion\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UpdateQuestionConclusionTextAction extends Action
{
    public function run(Request $request)
    {

        $data = [
            'conclusion'        => html_entity_decode(stripslashes($request->conclusion)),
            'conclusion_editer' => \Auth::user()->username,
            'conclusion_status' => $request->conclusion_status,
            'conclusion_at'     => now(),
            'status'            => '审核中',
        ];

        $plan_depart_question = Apiato::call('PlanDepartQuestion@UpdateMobilePlanDepartQuestionTask', [$request->id, $data]);

        return $plan_depart_question;
    }
}
