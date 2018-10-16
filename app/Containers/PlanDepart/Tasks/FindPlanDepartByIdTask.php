<?php

namespace App\Containers\PlanDepart\Tasks;

use App\Containers\PlanDepart\Data\Repositories\PlanDepartRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindPlanDepartByIdTask extends Task
{

    private $repository;

    public function __construct(PlanDepartRepository $repository)
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
