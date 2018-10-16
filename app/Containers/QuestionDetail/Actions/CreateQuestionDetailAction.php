<?php

namespace App\Containers\QuestionDetail\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class CreateQuestionDetailAction extends Action
{
    public function run(Request $request)
    {
        $data = [
            'question'                => $request->question,
            'answer'                  => html_entity_decode(stripslashes($request->answer)),
            'plan_depart_question_id' => $request->plan_depart_question_id,
        ];

        $question_detail = Apiato::call('QuestionDetail@CreateQuestionDetailTask', [$data]);

        return $question_detail;
    }
}
