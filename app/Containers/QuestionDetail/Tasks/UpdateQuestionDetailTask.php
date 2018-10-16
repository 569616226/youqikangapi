<?php

namespace App\Containers\QuestionDetail\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\QuestionDetail\Data\Repositories\QuestionDetailRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateQuestionDetailTask extends Task
{

    private $repository;

    public function __construct(QuestionDetailRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id, array $data)
    {
        try {

            \DB::beginTransaction();

            $question_detail = Apiato::call('QuestionDetail@FindQuestionDetailByIdTask', [$id]);

            $plan_depart_question = ['client_answer_editer' => \Auth::user()->username];
            Apiato::call('PlanDepartQuestion@UpdateMobilePlanDepartQuestionTask', [$question_detail->plan_depart_question->id, $plan_depart_question]);

            $question_detail = $this->repository->update($data, $id);

            \DB::commit();

            return $question_detail;

        } catch (Exception $exception) {
            \DB::rollback();
            throw new UpdateResourceFailedException();
        }
    }
}
