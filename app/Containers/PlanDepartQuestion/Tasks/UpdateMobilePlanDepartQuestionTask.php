<?php

namespace App\Containers\PlanDepartQuestion\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\PlanDepartQuestion\Data\Repositories\PlanDepartQuestionRepository;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateMobilePlanDepartQuestionTask extends Task
{

    private $repository;

    public function __construct(PlanDepartQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id, array $data)
    {

        try {

            return $this->repository->update($data, $id);

        } catch (Exception $exception) {

            report($exception);
            throw new UpdateResourceFailedException();
        }
    }
}
