<?php

namespace App\Containers\PlanDepartQuestion\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class CreatePlanDepartQuestionAction extends Action
{
    public function run(Request $request)
    {
        $data = [
            'question'       => $request->question,
            'answers'        => $request->answers,
            'plan_depart_id' => $request->plan_depart_id,
            'status'         => '未开始',
        ];

        $plandepartquestion = Apiato::call('PlanDepartQuestion@CreatePlanDepartQuestionTask', [$data]);

        return $plandepartquestion;
    }
}
