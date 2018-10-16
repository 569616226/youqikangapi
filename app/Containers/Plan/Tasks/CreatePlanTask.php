<?php

namespace App\Containers\Plan\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Plan\Data\Repositories\PlanRepository;
use App\Containers\Plan\Models\Plan;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\Auth;

class CreatePlanTask extends Task
{

    private $repository;

    public function __construct(PlanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $plan_data)
    {

        try {

            \DB::beginTransaction();

            $data = [
                'name'      => $plan_data['name'],
                'is_parent' => $plan_data['is_parent'] ?? false,
                'editer'    => Auth::user()->username,
            ];

            /*
             * 创建方案
             * */
            $plan = $this->repository->create($data);

            if ($plan) {

                if (array_key_exists('plan_departs', $plan_data) && count($plan_data['plan_departs'])) {

                    foreach ($plan_data['plan_departs'] as $plan_depart) {

                        $plan_depart_data = [
                            'name'    => $plan_depart['name'],
                            'icon'    => $plan_depart['icon'],
                            'plan_id' => $plan->id,
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

                        if (array_key_exists('plan_depart_questions', $plan_depart) && count($plan_depart['plan_depart_questions'])) {

                            foreach ($plan_depart['plan_depart_questions'] as $plan_depart_question) {
                                /*
                                  * 插入部门问题
                                  *
                                  * */
                                $plan_depart_question_data = [
                                    'question'       => $plan_depart_question['question'],
                                    'answers'        => $plan_depart_question['answers'],
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

                    }
                }

                \DB::commit();
                return $plan;

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
