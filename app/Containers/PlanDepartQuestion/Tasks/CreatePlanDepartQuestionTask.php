<?php

namespace App\Containers\PlanDepartQuestion\Tasks;

use App\Containers\Plan\Events\UpdatePlanEvent;
use App\Containers\PlanDepartQuestion\Data\Repositories\PlanDepartQuestionRepository;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Containers\PlanDepart\Models\PlanDepart;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreatePlanDepartQuestionTask extends Task
{

    private $repository;

    public function __construct(PlanDepartQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $data)
    {
        try {

            $plan_depart = PlanDepart::find($data['plan_depart_id']);

            $is_empty = $plan_depart->plan_depart_questions()->where('question', $data['question'])->get()->isEmpty();
            if ($is_empty) {

                $plan_depart_question = $this->repository->create($data);

                if ($plan_depart_question) {

                  //更新方案编辑人和时间
                  \App::make(\Illuminate\Contracts\Bus\Dispatcher::class)
                    ->dispatch(new UpdatePlanEvent($plan_depart_question->plan_depart->plan));

                    return $plan_depart_question;

                } else {

                    return error_simple_respone();

                }

            } else {

                return error_simple_respone('问题已经存在');

            }

        } catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }
    }
}
