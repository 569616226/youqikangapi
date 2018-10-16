<?php

namespace App\Containers\PlanDepartQuestion\Tasks;

use App\Containers\PlanDepartQuestion\Data\Repositories\PlanDepartQuestionRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class AuditMoreQuestionsTask extends Task
{

    private $repository;

    public function __construct(PlanDepartQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($ids, array $data)
    {

        try {

            \DB::beginTransaction();


            if (\Auth::user()->is_audit) {

                foreach ($ids as $id) {

                    $plan_depart_question = $this->repository->update($data, $id);

                    if (!$plan_depart_question) {

                        \DB::rollback();
                        return error_simple_respone();

                    }

                }

                \DB::commit();
                return success_simple_respone();

            } else {

                \DB::rollback();
                return error_simple_respone('负责人才能审核');
            }

        } catch (Exception $exception) {

            report($exception);
            \DB::rollback();
            throw new UpdateResourceFailedException();
        }
    }
}
