<?php

namespace App\Containers\QuestionDetail\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\QuestionDetail\Data\Repositories\QuestionDetailRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteQuestionDetailTask extends Task
{

    private $repository;

    public function __construct(QuestionDetailRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($ids)
    {

        try {

            \DB::beginTransaction();

            $result = false;
            if (is_array($ids)) {

                foreach ($ids as $id) {

                    $result = $this->repository->delete($id);

                    if (!$result) {
                        break;
                    }

                }

            } else {

                $question_detail = Apiato::call('QuestionDetail@FindQuestionDetailByIdTask', [$ids]);

                $plan_depart_question_data = ['client_answer_editer' => \Auth::user()->username];
                Apiato::call('PlanDepartQuestion@UpdateMobilePlanDepartQuestionTask', [$question_detail->plan_depart_question->id, $plan_depart_question_data]);

                $result = $this->repository->delete($ids);

            }

            /* 删除成功 返回成功信息，删除失败返回失败信息*/
            if ($result) {
                \DB::commit();
                return success_simple_respone('问题删除成功');
            } else {
                \DB::rollback();
                return error_simple_respone();
            }


        } catch (Exception $exception) {
            report($exception);
            \DB::rollback();
            throw new DeleteResourceFailedException();
        }

    }

}
