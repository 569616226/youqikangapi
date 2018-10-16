<?php

namespace App\Containers\Plan\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Plan\Data\Repositories\PlanRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\Auth;

class CreatePlanWithPlanIdTask extends Task
{

    private $repository;

    public function __construct(PlanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($plan_id)
    {

        try {

            \DB::beginTransaction();

            $plan = Apiato::call('Plan@FindPlanByIdTask', [$plan_id]);

            $data = [
                'name'      => $plan->name . '-副本-'.time(),
                'is_parent' => $plan->is_parent,
                'editer'    => Auth::user()->username,
            ];

            // 创建方案
            $new_plan = $this->repository->create($data);

            if ($new_plan) {

                foreach ($plan->plan_departs as $plan_depart) {

                    $plan_depart_data = [
                        'name'    => $plan_depart->name,
                        'icon'    => $plan_depart->icon,
                        'plan_id' => $new_plan->id,
                    ];

                    /*
                     * 插入部门
                     *
                     * */
                    $new_depart = Apiato::call('PlanDepart@CreatePlanDepartTask', [
                        $plan_depart_data
                    ]);

                    if (!$new_depart) {

                        \DB::rollback();
                        return false;

                    }


                    foreach ($plan_depart->plan_depart_questions as $plan_depart_question) {
                        /*
                          * 插入部门问题
                          *
                          * */
                        $plan_depart_question_data = [
                            'question'       => $plan_depart_question->question,
                            'answers'        => $plan_depart_question->answers,
                            'plan_depart_id' => $new_depart->id,
                            'status'         => '未开始',
                        ];

                        $new_question = Apiato::call('PlanDepartQuestion@CreatePlanDepartQuestionTask', [
                            $plan_depart_question_data
                        ]);

                        if (!$new_question) {

                            \DB::rollback();
                            return false;

                        }

                    }
                }

                \DB::commit();
                return $new_plan;

            } else {

                \DB::rollback();
                return false;

            }

        } catch (Exception $exception) {

            report($exception);
            \DB::rollback();
            throw new CreateResourceFailedException();
        }
    }
}
