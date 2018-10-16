<?php

namespace App\Containers\QuestionDetail\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\QuestionDetail\Data\Repositories\QuestionDetailRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateQuestionDetailTask extends Task
{

    private $repository;

    public function __construct(QuestionDetailRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $data)
    {
        try {

            \DB::beginTransaction();

            $plan_depart_question = ['client_answer_editer' => \Auth::user()->username];
            Apiato::call('PlanDepartQuestion@UpdateMobilePlanDepartQuestionTask', [$data['plan_depart_question_id'], $plan_depart_question]);

            $question_detail = $this->repository->create($data);

            \DB::commit();

            return $question_detail;

        } catch (Exception $exception) {

            \DB::rollback();
            throw new CreateResourceFailedException();

        }
    }
}
