<?php

namespace App\Containers\PlanDepartQuestion\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class DeletePlanDepartQuestionAction extends Action
{
    public function run(Request $request)
    {

        $plan_depart_question = Apiato::call('PlanDepartQuestion@FindPlanDepartQuestionByIdTask', [$request->id]);

        /*
      * 判断是否可以删除
      *
      * 如果不可以删除返回提示信息
     */
        $is_del = is_del_plan($plan_depart_question->plan_depart->plan);

        if (is_string($is_del)) {

            return error_simple_respone($is_del);

        } else {

            return Apiato::call('PlanDepartQuestion@DeletePlanDepartQuestionTask', [$request->id]);

        }


    }
}
