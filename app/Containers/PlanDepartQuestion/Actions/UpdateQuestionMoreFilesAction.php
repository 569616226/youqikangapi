<?php

namespace App\Containers\PlanDepartQuestion\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UpdateQuestionMoreFilesAction extends Action
{
    public function run(Request $request)
    {

        $plan_depart_question = Apiato::call('PlanDepartQuestion@FindPlanDepartQuestionByIdTask', [$request->id]);

        $more_files = $plan_depart_question->more_files ?? [];
        $more_file = $request->more_file;
        array_push($more_files, $more_file);

        $data = [
            'more_files'           => $more_files,
            'client_answer_editer' => \Auth::user()->username,
        ];

        $plan_depart_question = Apiato::call('PlanDepartQuestion@UpdateMobilePlanDepartQuestionTask', [$request->id, $data]);

        return $plan_depart_question;
    }
}
