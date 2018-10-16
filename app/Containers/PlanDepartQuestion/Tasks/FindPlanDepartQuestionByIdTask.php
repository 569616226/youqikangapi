<?php

namespace App\Containers\PlanDepartQuestion\Tasks;

use App\Containers\PlanDepartQuestion\Data\Repositories\PlanDepartQuestionRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindPlanDepartQuestionByIdTask extends Task
{

    private $repository;

    public function __construct(PlanDepartQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id)
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
