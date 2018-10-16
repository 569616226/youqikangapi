<?php

namespace App\Containers\Plan\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdatePlanTask extends Task
{

    public function run($id, array $plan_data)
    {
        try {

            \DB::beginTransaction();

            $plan = Apiato::call('Plan@FindPlanByIdTask', [$id]);

            $data = [
                'name'   => $plan_data['name'],
                'editer' => \Auth::user()->username
            ];

            if ($plan) {

                if (optional($plan->order)->status == '已完成') {

                    return error_simple_respone('该方案的订单已经完成,不能编辑删除方案内容');

                } else {
                    /*
                 * 更新方案
                 * */
                    $new_plan = $plan->update($data);

                    if (!$new_plan) {

                        \DB::rollback();
                        return error_simple_respone();
                    }

                    if (array_key_exists('plan_departs', $plan_data)) {

                        foreach ($plan_data['plan_departs'] as $plan_depart) {

                            /*删除部门*/
                            if (array_key_exists('del', $plan_depart)) {

                                $result = Apiato::call('PlanDepart@DeletePlanDepartTask', [$plan_depart['id']]);

                                if (!$result) {

                                    \DB::rollback();
                                    return error_simple_respone();
                                } else {
                                    if (array_key_exists('plan_depart_questions', $plan_depart)) {

                                        foreach ($plan_depart['plan_depart_questions'] as $plan_depart_question) {

                                            /*删除问题*/
                                            Apiato::call('PlanDepartQuestion@DeletePlanDepartQuestionTask', [$plan_depart_question['id']]);

                                        }
                                    }
                                }


                            } elseif (array_key_exists('id', $plan_depart)) {

                                $plan_depart_data = [
                                    'name' => $plan_depart['name'],
                                    'icon' => $plan_depart['icon'],
                                ];

                                /*
                                 * 更新部门
                                 *
                                 * */
                                $result = Apiato::call('PlanDepart@UpdatePlanDepartTask', [$plan_depart['id'], $plan_depart_data]);

                                if (!$result) {

                                    \DB::rollback();
                                    return error_simple_respone();

                                } else {

                                    if (array_key_exists('plan_depart_questions', $plan_depart)) {

                                        foreach ($plan_depart['plan_depart_questions'] as $plan_depart_question) {

                                            if (array_key_exists('del', $plan_depart_question)) {
                                                /*删除问题*/
                                                Apiato::call('PlanDepartQuestion@DeletePlanDepartQuestionTask', [$plan_depart_question['id']]);

                                            } elseif (array_key_exists('id', $plan_depart_question)) {
                                                /*更新问题*/
                                                $plan_depart_question_data = [
                                                    'question' => $plan_depart_question['question'],
                                                    'answers'  => $plan_depart_question['answers'],

                                                ];

                                                $result = Apiato::call('PlanDepartQuestion@UpdatePlanDepartQuestionTask', [$plan_depart_question['id'], $plan_depart_question_data]);

                                                if (!$result) {

                                                    \DB::rollback();
                                                    return error_simple_respone();
                                                }

                                            } else {

                                                //插入部门问题
                                                $plan_depart_question_data = [
                                                    'question'       => $plan_depart_question['question'],
                                                    'answers'        => $plan_depart_question['answers'],
                                                    'plan_depart_id' => $plan_depart['id'],
                                                ];

                                                $plan_depart_question = Apiato::call('PlanDepartQuestion@CreatePlanDepartQuestionTask', [
                                                    $plan_depart_question_data
                                                ]);

                                                if (!$plan_depart_question instanceof PlanDepartQuestion) {

                                                    \DB::rollback();
                                                    return $plan_depart_question;
                                                }
                                            }

                                        }
                                    }
                                }

                            } else {

                                $plan_depart_data = [
                                    'name'    => $plan_depart['name'],
                                    'icon'    => $plan_depart['icon'],
                                    'plan_id' => $plan->id,
                                ];

                                /*
                                 * 插入部门
                                 *
                                 * */
                                $plan_depart = Apiato::call('PlanDepart@CreatePlanDepartTask', [
                                    $plan_depart_data
                                ]);

                                if (!$plan_depart) {

                                    \DB::rollback();
                                    return error_simple_respone();

                                } else {

                                    if (array_key_exists('plan_depart_questions', $plan_depart)) {

                                        foreach ($plan_depart['plan_depart_questions'] as $plan_depart_question) {

                                            //插入部门问题
                                            $plan_depart_question_data = [
                                                'question'       => $plan_depart_question['question'],
                                                'answers'        => $plan_depart_question['answers'],
                                                'plan_depart_id' => $plan_depart['id'],
                                            ];

                                            $plan_depart_question = Apiato::call('PlanDepartQuestion@CreatePlanDepartQuestionTask', [
                                                $plan_depart_question_data
                                            ]);

                                            if (!$plan_depart_question instanceof PlanDepartQuestion) {

                                                \DB::rollback();
                                                return $plan_depart_question;
                                            }

                                        }
                                    }
                                }

                            }

                        }
                    }


                    \DB::commit();

                    return $plan;

                }

            } else {

                \DB::rollback();

                return error_simple_respone();
            }

        } catch (Exception $exception) {

            \DB::rollback();

            report($exception);
            throw new UpdateResourceFailedException();
        }
    }
}
