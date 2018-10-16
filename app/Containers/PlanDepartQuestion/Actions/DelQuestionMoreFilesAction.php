<?php

namespace App\Containers\PlanDepartQuestion\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class DelQuestionMoreFilesAction extends Action
{
    public function run(Request $request)
    {

        $plan_depart_question = Apiato::call('PlanDepartQuestion@FindPlanDepartQuestionByIdTask', [$request->id]);

        $more_files = $plan_depart_question->more_files ?? [];
        $image_url_index = $request->image_url_index;

        $data = [
            'more_files'           => array_values(array_except($more_files, [$image_url_index])),
            'client_answer_editer' => \Auth::user()->username,
        ];

        $plan_depart_question = Apiato::call('PlanDepartQuestion@UpdateMobilePlanDepartQuestionTask', [$request->id, $data]);

        return $plan_depart_question;
    }
}
