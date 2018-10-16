<?php

namespace App\Containers\QuestionDetail\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class UpdateQuestionDetailAction extends Action
{
    public function run(Request $request)
    {
        $data = [
            'question' => $request->question,
            'answer'   => html_entity_decode(stripslashes($request->answer)),
        ];

        $question_detail = Apiato::call('QuestionDetail@UpdateQuestionDetailTask', [$request->id, $data]);

        return $question_detail;
    }
}
