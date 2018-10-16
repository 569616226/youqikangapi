<?php

namespace App\Containers\QuestionDetail\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class FindQuestionDetailByIdAction extends Action
{
    public function run(Request $request)
    {
        $question_detail = Apiato::call('QuestionDetail@FindQuestionDetailByIdTask', [$request->id]);

        return $question_detail;
    }
}
