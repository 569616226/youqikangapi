<?php

namespace App\Containers\PlanDepartQuestion\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Plan\Events\UpdatePlanEvent;
use App\Containers\PlanDepartQuestion\Data\Repositories\PlanDepartQuestionRepository;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdatePlanDepartQuestionTask extends Task
{

    private $repository;

    public function __construct(PlanDepartQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id, array $data)
    {

        try {

            $plan_depart_question = Apiato::call('PlanDepartQuestion@FindPlanDepartQuestionByIdTask', [$id]);

            /*如果是标准库修改，增加编辑人修改*/
            $plan = $plan_depart_question->plan_depart->plan;

            //更新方案编辑人和时间
            \App::make(\Illuminate\Contracts\Bus\Dispatcher::class)
              ->dispatch(new UpdatePlanEvent($plan));

            $is_empty = $plan_depart_question->plan_depart->plan_depart_questions()->where('question', $data['question'])->get()->isEmpty();

            if ($plan_depart_question->question == $data['question'] || $is_empty) {

                $update_plan_depart_question = $this->repository->update($data, $id);

                if ($update_plan_depart_question) {

                    return success_simple_respone('问题更新成功');

                } else {

                    return error_simple_respone();

                }

            } else {

                return error_simple_respone('问题已经存在');

            }


        } catch (Exception $exception) {

            report($exception);
            throw new UpdateResourceFailedException();
        }
    }
}
