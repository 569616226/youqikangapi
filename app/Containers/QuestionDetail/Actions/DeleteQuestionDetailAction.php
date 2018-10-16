<?php

namespace App\Containers\QuestionDetail\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class DeleteQuestionDetailAction extends Action
{
    public function run(Request $request)
    {

        $question_detail = Apiato::call('QuestionDetail@FindQuestionDetailByIdTask', [$request->id]);

        /*
         * 判断是否可以删除
         *
         * 如果不可以删除返回提示信息
        */
        $is_del = is_del_plan($question_detail->plan_depart_question->plan_depart->plan);

        if (is_string($is_del)) {

            \DB::rollback();
            return error_simple_respone($is_del);

        } else {

            return Apiato::call('QuestionDetail@DeleteQuestionDetailTask', [$request->id]);

        }

    }
}
